<?php

class WiseWireApiSearch
{
    private $filters;
    private $grades;
    private $synonyms = array(  "grade 1", "first grade", "1st grade", "grade one", "grade 2",
                                "second grade", "2nd grade", "grade two", "grade 3", "third grade",
                                "3rd grade", "grade three", "grade 4", "fourth grade", "4th grade",
                                "grade four", "grade 5", "fifth grade", "5th grade", "grade five",
                                "grade 6", "sixth grade", "6th grade", "grade six", "grade 7",
                                "seventh grade", "7th grade", "grade seven", "grade 8", "eighth grade",
                                "8th grade", "grade eight", "grade 9", "ninth grade", "9th grade",
                                "grade nine", "grade 10", "tenth grade", "10th grade", "grade ten",
                                "grade 11", "eleventh grade", "11th grade", "grade eleven", "grade 12",
                                "twelfth grade", "12th grade", "grade twelve", "grade k",
                                "tech-enhanced item", "technology-enhanced item", "tech enhanced item",
                                "technology enhanced item", "upper level", "english language arts",
                                "language arts", "non fiction", "high school", "test items", "lesson plan",
                                "lesson planning", "lesson plans", "multimedia resources", "Open response",
                                "free response", "Performance task", "performance tasks", "Teacher guide",
                                "teacher edition", "teacher version", "teacher guides", 
                                "teacher editions", "teacher versions",
                                "Partnership for Assessment of Readiness for College and Careers",
                                "Smarter Balance", "Smarter Balance Assessment",
                                "Smarter Balance Assessment Consortium", "Common Core",
                                "Common Core State Standards", "national standards",
                                "international Society for Technology in Education",
                                "National Educational Technology Standards",
                                "technology standards", "international test and evaluation association",
                                "international test and evaluation", "national council for social studies",
                                "social studies standards", "national standards for social studies",
                                "national council of teachers of mathematics", "national math standards",
                                "next gen science", "next generation science standards",
                                "next gen standards", "national science education standards",
                                "national science standards", "texas standards",
                                "texas essential knowledge and skills", "Virginia standards",
                                "Virginia standards of learning", "power point", "web site", "web page",
                                "pre-k", "pre-school", "pre-schooler", "e-reader", "e-readers", "high-school", 
                                "higher-education" );


    public function __construct($filters = array())
    {
        $filters['wt'] = 'json';
        $this->filters = $filters;
    }

    private function executeSearch($data_params, $url_additional = 'select')
    {
        $query_string = http_build_query($data_params);
        $query_string = preg_replace('/%5B[0-9]+%5D/simU', '', $query_string);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, URL_API_SEARCH_SOLR . $url_additional . '?' . $query_string);  
        //echo URL_API_SEARCH_SOLR . $url_additional . '?' . $query_string."<br>";

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($ch);
       
        if ($curl_response === FALSE) {
            error_log("\n" . date("Y-m-d h:i:s") . " Error calling API Search Solr:" . URL_API_SEARCH_SOLR, 3, ABSPATH . 'tmp/log/errors.log');
            return false;
        }

        curl_close($ch);
        return $curl_response;
    }

    public function get_all_grade_by_discipline($discipline_slug, $grade)
    {
        $grades_ids = Controller_WiseWireItems::GetGradesIds($grade);

        $filters = $this->filters;
        $filters['q'] = "discipline_slug:" . $discipline_slug;      
        $filters['rows'] = 500;  
        $filters['fq'] = 'grade_id:(*'.implode("* OR *", $grades_ids ).'*)';
     
        $discipline = $this->executeSearch($filters);
        $discipline = json_decode($discipline);        

        $this->grades = count($discipline->response->docs) > 0 ? $discipline->response->docs : array();
        return $this->grades;
    }

    public function get_one_grade()
    {
        return count($this->grades) > 0 ? $this->grades[0] : null;
    }

    public function get_data_by_groups($group_field = null, $sort_field = null, $filter_not_null = true)
    {
        $filters = $this->filters;
        $filters['group'] = 'true';
        $filters['group.limit'] = 0;
        $filters['group.field'] = $group_field;
        $filters['rows'] = 500;
        $filters['sort'] = $sort_field;

        if($filter_not_null){
            $filters['fq'][] = $group_field .':[* TO *]';
        }

        $data_by_groups = $this->executeSearch($filters);
        $data_by_groups = json_decode($data_by_groups);

        if (isset($data_by_groups->error)) {
            error_log("\n" . date("Y-m-d h:i:s") . " Error calling API Search Solr" . URL_API_SEARCH_SOLR . " Code: " .
                $data_by_groups->error->code . " Message: " . $data_by_groups->error->msg, 3, ABSPATH . 'tmp/log/errors.log');
            return false;
        }

        return $data_by_groups->grouped;
    }

    public function get_data_by_object_type($group_field = null, $sort_field = null, $filter_not_null = true)
    {
        $filters = $this->filters;        
        $filters['facet'] = 'true';
        $filters['facet.pivot'] = $group_field;
        $filters['rows'] = 0;        

        $data_by_groups = $this->executeSearch($filters);
        $data_by_groups = json_decode($data_by_groups);

        if (isset($data_by_groups->error)) {
            error_log("\n" . date("Y-m-d h:i:s") . " Error calling API Search Solr" . URL_API_SEARCH_SOLR . " Code: " .
                $data_by_groups->error->code . " Message: " . $data_by_groups->error->msg, 3, ABSPATH . 'tmp/log/errors.log');
            return false;
        }

        return $data_by_groups->facet_counts;
    }

    public function get_populate_posts()
    {
        $populate_post = $this->executeSearch($this->filters);
        $populate_post = json_decode($populate_post);

        if (isset($populate_post->error)) {
            error_log("\n" . date("Y-m-d h:i:s") . " Error calling API Search Solr" . URL_API_SEARCH_SOLR . " Code: " .
                $populate_post->error->code . " Message: " . $populate_post->error->msg, 3, ABSPATH . 'tmp/log/errors.log');
            return false;
        }

        $response = $populate_post->response;

        return $response;
    }


    public function get_spellcheck_by_keyword($keyword)
    {
        $filter = $this->filters;
        $filter['spellcheck'] = 'on';
        $filter['q'] = '("'.$keyword.'")';

        $spellcheck = $this->executeSearch($filter, 'spell');
        $spellcheck = json_decode($spellcheck);

        if (isset($spellcheck->error)) {
            error_log("\n" . date("Y-m-d h:i:s") . " Error calling API Search Solr" . URL_API_SEARCH_SOLR . " Code: " .
                $spellcheck->error->code . " Message: " . $spellcheck->error->msg, 3, ABSPATH . 'tmp/log/errors.log');
            return false;
        }

        $response = ($spellcheck->spellcheck->collations ? $spellcheck->spellcheck->collations : null);

        return $response;
    }

    public function find_synonyms($search_word){
        
        foreach ($this->synonyms as $value) {               
            if ( stripos($value , $search_word) !== FALSE ){                                
                $length_value = strlen($value);                
                return substr($search_word,  stripos( $search_word, $value), $length_value);
            } 
        }       
        return false;
    }


}
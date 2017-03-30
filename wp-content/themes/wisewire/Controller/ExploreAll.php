<?php
require_once(ABSPATH . 'wp-includes/WiseWireApiSearch.php');


class Controller_ExploreAll
{
    public $grade;
    public $discipline;
    public $discipline_object;
    public $list_view; // 'grid' or 'list';

    public $filters_key;
    public $filter_content_types;
    public $filter_object_types;
    public $filter_standards;
    public $filter_contributors;
    public $filter_ranking;
    public $filter_dok;
    public $filter_grades;
    public $filter_license_type;

    public $filters;
    public $order_by;

    public $search = null;
    public $page = 'exploreall';

    public $populate_data_posts;
    public $grades_discipline;
    public $search_keyword_sepllcheck;
    public $title;


    public function __construct($filters_key = null)
    {
        global $wp_query, $wpdb;

        $this->wp_query = $wp_query;
        $this->page_nr = isset($this->wp_query->query['page_nr']) ? intval($this->wp_query->query['page_nr']) : 1;

        $this->on_page = isset($_REQUEST['on_page']) ? $_REQUEST['on_page'] : 18;

        $this->grade = isset($this->wp_query->query['grade']) ? $this->wp_query->query['grade'] : 'middle';
        $this->discipline = isset($this->wp_query->query['discipline']) ? $this->wp_query->query['discipline'] : '';

        $this->filters_key = $filters_key ? $filters_key : $this->grade . ';' . $this->discipline;

        if ($this->discipline) {
            $api_search_solr = new WiseWireApiSearch();
            $this->grades_discipline = $api_search_solr->get_all_grade_by_discipline(esc_sql($this->discipline), $this->grade);
            $this->discipline_object = $api_search_solr->get_one_grade();
        }

        $this->search = isset($this->wp_query->query['search']) ? stripslashes(urldecode($this->wp_query->query['search'])) : false;
        if ($this->search) {
            $this->search_solr = $this->escapeSolrValue(trim($this->search));
        }

        $this->is_spellchecker = isset($_REQUEST['sepllcheck']) ? true : false;

        // if discipline not found go back to explore page
        if ($this->page == 'exploreall' && !$this->discipline_object && $this->search === false) {
            wp_redirect(get_site_url() . ' /explore/' . $this->grade . '/');
        }

        $this->catch_filters();
        $this->load_sepllchecker();
        $populate_post = $this->populate_posts();
        $this->populate_data_posts = $populate_post->docs;
        $this->posts_count = $populate_post->numFound;
        $this->load_data_to_filters();

        if ($this->search === false) {
            $_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $table_name = $wpdb->prefix . "wan_custom_seo";
            $custom_seo = $wpdb->get_row("SELECT title, meta_description from $table_name WHERE url='https://$_url';");
            $_title = !empty($custom_seo->title) ? $custom_seo->title : null;
            $_meta_description = !empty($custom_seo->meta_description) ? $custom_seo->meta_description : null;

            if ($_title == null) {
                $this->title = "Explore School Resources for Teachers - " . ucwords(str_replace('-', ' ', $this->grade)) . " School - " . $this->discipline_object->level1_label;
            } else {
                $this->title = $_title;
            }
            if ($_meta_description) {
                $this->meta_description = $_meta_description;
            }
        }


        if ($this->posts_count > 0) {

            $this->pages_count = ceil($this->posts_count / $this->on_page);

            if ($this->page_nr < 1) {
                $this->page_nr = 1;
            }
            if ($this->page_nr > $this->pages_count) {
                $this->page_nr = $this->pages_count;
            }

            $this->offset = ($this->page_nr - 1) * $this->on_page;

            if ($this->posts_count > $this->offset + $this->on_page) { # not last
                $this->actual_on_page = $this->on_page;
            } else if ($this->offset > 0) { # last
                $this->actual_on_page = $this->posts_count % $this->offset;
            } else { # first
                $this->actual_on_page = $this->posts_count;
            }
        }
    }

    private function escapeSolrValue($string)
    {
        $match = array('\\', '+', '-', '&', '|', '!', '(', ')', '{', '}', '[', ']', '^', '~', '*', '?', ':', '"', ';', '_');
        $replace = array('\\\\', '\\+', '\\-\\', '\\&', '\\|', '\\!', '\\(', '\\)', '\\{', '\\}', '\\[', '\\]', '\\^', '\\~', '\\*', '\\?', '\\:', '\\"', '\\;', '\\_\\');
        $string = str_replace($match, $replace, $string);

        return $string;
    }


    protected function get_filters($base = false)
    {
        $conditions = array();
        if ($this->search === false) {
            $conditions['q'] = '*:*';
        }

        if (isset($_REQUEST['nogrades'])) {
            $this->search = true;
        }

        if ($this->grade && $this->search === false) {
            $this->grades_ids = Controller_WiseWireItems::GetGradesIds($this->grade);
            $conditions['fq'][] = 'grade_id:(*' . implode("* OR *", $this->grades_ids) . '*)';
        }

        if ($this->discipline_object) {
            $conditions['fq'][] = "discipline_id:" . $this->discipline_object->discipline_id;
        }

        if ($this->filters && $base === false) {
            if (isset($this->filters['subdiscipline']) && count($this->filters['subdiscipline'])) {
                $conditions['fq'][] = 'subdiscipline:("' . implode('" OR "', $this->filters['subdiscipline']) . '")';
            }

            if (isset($this->filters['standard']) && count($this->filters['standard'])) {
                $conditions['fq'][] = 'standard:("' . implode('" OR "', $this->filters['standard']) . '")';
            }

            if (isset($this->filters['content_type']) && count($this->filters['content_type'])) {
                $conditions['fq'][] = 'content_type_icon:("' . implode('" OR "', $this->filters['content_type']) . '")';
            }

            if (isset($this->filters['object_type']) && count($this->filters['object_type'])) {
                $conditions['fq'][] = 'object_type:("' . implode('" OR "', $this->filters['object_type']) . '")';
            }

            if (isset($this->filters['contributor']) && count($this->filters['contributor'])) {
                $conditions['fq'][] = 'author:("' . implode('" OR "', $this->filters['contributor']) . '")';
            }

            if (isset($this->filters['dok']) && count($this->filters['dok'])) {
                $conditions['fq'][] = 'dok:("' . implode('" OR "', $this->filters['dok']) . '")';
            }

            if (isset($this->filters['ranking']) && count($this->filters['ranking'])) {
                if (isset($this->filters['ranking'][0]) && $this->filters['ranking'][0] == 0) {
                    $conditions['fq'][] = '-ratings:[* TO *]';
                } else {
                    $conditions['fq'][] = 'ratings:(' . implode(" OR ", $this->filters['ranking']) . ')';
                }
            }

            if (isset($this->filters['gradelevel']) && count($this->filters['gradelevel'])) {
                $conditions['fq'][] = 'grade_id:(*' . implode("* OR *", $this->filters['gradelevel']) . '*)';
            }

            if (isset($this->filters['license_type']) && count($this->filters['license_type'])) {
                $conditions['fq'][] = 'license_type:("' . implode('" OR "', $this->filters['license_type']) . '")';
            }
        }

        if (isset($_REQUEST['nogrades'])) {
            $this->search = false;
        }

        if ($this->search !== false) {

            /*Search for synonyms*/
            $data_keywords = $this->search_for_synonyms($this->search_solr);

            if (count($data_keywords) > 1) {
                $conditions['q'] = "*:*";
                $conditions['fq'][] = 'keyword:"' . implode('" AND keyword:"', $data_keywords) . '"';
            } else {
                $conditions['q'] = 'keyword:"' . $data_keywords[0] . '"';
            }
        }

        return $conditions;
    }

    public function search_for_synonyms($search_solr)
    {

        $api_search = new WiseWireApiSearch();
        $data_synonym = $api_search->find_synonyms($search_solr);

        if ($data_synonym) {
            $search_solr_without_syn = explode($data_synonym, $search_solr);
            $search_solr_without_syn = implode(" ", $search_solr_without_syn);
            $data_keywords = $data = preg_split("/\s+/", $search_solr_without_syn);
            array_push($data_keywords, $data_synonym);
            $data_keywords = array_filter($data_keywords);
        } else {
            $data_keywords = $data = preg_split("/\s+/", $this->search_solr);
        }

        return array_values($data_keywords);
    }

    public function filter_requested($filter)
    {
        return isset($_POST['filter']) && $_POST['filter'] === $filter;
    }

    private function get_current_grades_ids()
    {
        $data_grades_disciplines = $this->get_all_grades_disciplines();

        $data_current_grades_ids = array_intersect(array_keys($data_grades_disciplines), Controller_WiseWireItems::GetGradesIds($this->grade));

        return $data_current_grades_ids;
    }

    private function get_all_grades_disciplines()
    {
        $data_grades = array();

        if (isset($this->grades_discipline) and $this->grades_discipline) {
            foreach ($this->grades_discipline as $value) {
                $grade_ids = explode(',', $value->grade_id);
                foreach ($grade_ids as $k => $v) {
                    $data_grades[$v] = $value->grade[$k];
                }
            }
        }

        return $data_grades;
    }

    public function populate_posts()
    {

        if ($this->search !== false && !$this->search) {
            return false;
        }

        $conditions = $this->get_filters();
        $conditions['indent'] = 'true';

        switch ($this->order_by) {
            case 'most_recent':
                $conditions['sort'] = 'publish_date DESC';
                break;
            default:
                if ($this->search !== false) {
                    $conditions['sort'] = 'ratings DESC';
                    //$order_by = 'x.`rank_weight` DESC, x.`item_ratings` DESC';
                } else {
                    $conditions['sort'] = 'ratings DESC';
                }
        }

        if ($this->on_page) {
            $start_page = $this->page_nr === 1 ? 0 : (($this->page_nr - 1) * $this->on_page);
            $conditions['start'] = $start_page;
            $conditions['rows'] = $this->on_page;
        }

        $api_search_solr = new WiseWireApiSearch($conditions);
        return $api_search_solr->get_populate_posts();
    }

    public function display_active_filters()
    {
        $s = '';
        if ($this->filters) {
            $title = '';
            foreach ($this->filters as $name => $values) {
                foreach ($values as $value) {
                    if ($name == 'subdiscipline' || $name == 'content_type' || $name == 'object_type' || $name == 'contributor' || $name == 'standard' || $name == 'license_type') {
                        $title = strtoupper($value);
                    } elseif ($name == 'ranking') {
                        $title = 'RATING: ' . (int)$value;
                    } elseif ($name == 'dok') {
                        $title = 'DOK: ' . $value;
                    } elseif (trim($name) == 'gradelevel') {
                        $title = $this->discipline_object ? strtoupper($this->get_all_grades_disciplines()[$value]) : strtoupper(Controller_WiseWireItems::GetGradesLabels($value));
                    }

                    $s .= '<li><a href="#' . $value . '" data-filter="' . $name . '" class="filter-remove">' . $title . '</a></li>';
                }
            }
        }

        return $s;
    }

    public function catch_filters()
    {

        if ($this->search !== false) {
            if ($_SESSION['exploreall_search'] != $this->search || isset($_REQUEST['clear_filters'])) {
                $_SESSION['exploreall_filters'] = array();
            }
            $_SESSION['exploreall_search'] = $this->search;
        } else if (isset($_REQUEST['clear_filters'])) {
            $_SESSION['exploreall_filters'] = array();
        }

        $this->list_view = isset($_COOKIE['exploreall_list_view']) ? $_COOKIE['exploreall_list_view'] : 'grid';

        $this->filters = isset($_SESSION['exploreall_filters'][$this->filters_key]) ? $_SESSION['exploreall_filters'][$this->filters_key] : array();

        if (isset($_REQUEST['filter'])) {

            $fname = $_REQUEST['filter'];
            $fval = $_REQUEST['filter_value'];

            if (!isset($this->filters[$fname])) {
                $this->filters[$fname] = array();
            }

            $this->filters[$fname][] = $fval;
            $this->filters[$fname] = array_unique($this->filters[$fname]);
        }

        if (isset($_REQUEST['filter_remove'])) {
            $fname = $_REQUEST['filter_remove'];
            $fval = $_REQUEST['filter_value'];

            if (isset($this->filters[$fname])) {
                $index = array_search($fval, $this->filters[$fname]);
                unset($this->filters[$fname][$index]);
            }
        }

        if (!isset($_REQUEST['filter']) && !isset($_REQUEST['filter_remove']) && !isset($_POST['filter'])) {
            if (!isset($_SESSION['exploreall_filters']) && $this->search === false) {

                if (!isset($this->filters["gradelevel"])) {
                    $this->filters["gradelevel"] = array();
                }

                $data_current_grades_ids = $this->get_current_grades_ids();
                $this->filters["gradelevel"] = $data_current_grades_ids;
            }

        }

        $key_order_by = $this->filters_key . ($this->search == false ? '' : $this->search);
        if (isset($_REQUEST['order_by'])) {
            $this->order_by = $_SESSION['exploreall_orderby'][$key_order_by] = $_REQUEST['order_by'];
        } elseif (isset($_SESSION['exploreall_orderby'][$key_order_by])) {
            $this->order_by = $_SESSION['exploreall_orderby'][$key_order_by];
        } else {
            $this->order_by = array();
        }

        $_SESSION['exploreall_filters'][$this->filters_key] = $this->filters;
    }

    public function get_permalink()
    {
        if ($this->search !== false) {
            return get_site_url() . '/explore/search/' . $this->search . '/';
        } else {
            return get_site_url() . '/explore/' . $this->grade . '/' . $this->discipline . '/';
        }
    }

    protected function load_sepllchecker()
    {
        if ($this->search && !$this->is_spellchecker) {
            $api_search_solr = new WiseWireApiSearch();
            $data_keywords = $this->search_for_synonyms($this->search_solr);

            if (count($data_keywords) > 1) {
                $this->search_keyword_sepllcheck = $api_search_solr->get_spellcheck_by_keyword(implode('"AND"', $data_keywords));
            } else {
                $this->search_keyword_sepllcheck = $api_search_solr->get_spellcheck_by_keyword($data_keywords[0]);
            }
        }
    }

    protected function load_grades($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_grades = $api_search_solr->get_data_by_groups('grade_id', 'grade_id ASC');
        $data_api_grades = $data_groups_grades->grade_id->groups;

        $data_current_grades = array();
        $data_current_grades_ids = array();
        $data_grades_disciplines = array();
        if ($this->discipline_object) {
            $data_grades_disciplines = $this->get_all_grades_disciplines();
            $data_current_grades_ids = $this->get_current_grades_ids();
            $data_current_grades_ids = array_flip($data_current_grades_ids);
        }

        foreach ($data_api_grades as $grade) {
            $data_grade_values = explode(',', $grade->groupValue);
            foreach ($data_grade_values as $value) {
                if ($this->discipline_object && !isset($data_current_grades_ids[$value])) {
                    continue;
                }

                $parent_grade_name = Controller_WiseWireItems::GetGradeName(array($value));
                $parent_grade_name = ucfirst($parent_grade_name);
                if (!isset($data_current_grades[$parent_grade_name])) {
                    $data_current_grades[$parent_grade_name] = array();
                    $data_current_grades[$parent_grade_name][$value]['count'] = 0;
                }
                $data_current_grades[$parent_grade_name][$value]['name'] = $this->discipline_object ? $data_grades_disciplines[$value] : Controller_WiseWireItems::GetGradesLabels($value);
                $data_current_grades[$parent_grade_name][$value]['term_id'] = $value;
                $data_current_grades[$parent_grade_name][$value]['count'] += $grade->doclist->numFound;
            }
        }

        ksort($data_current_grades[$parent_grade_name]);
        $this->filter_grades = $data_current_grades;
    }

    protected function load_subdisciplines($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_subdisciplines = $api_search_solr->get_data_by_groups('subdiscipline', 'subdiscipline ASC');
        $this->subdisciplines = $data_groups_subdisciplines->subdiscipline->groups;
    }

    protected function load_content_types($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_content_type_icon = $api_search_solr->get_data_by_groups('content_type_icon', 'content_type_icon ASC');
        $this->filter_content_types = $data_groups_content_type_icon->content_type_icon->groups;
    }

    protected function load_object_types($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_object_type = $api_search_solr->get_data_by_object_type('object_type', 'object_type ASC');
        $this->filter_object_types = $data_groups_object_type->facet_pivot->object_type;
    }

    protected function load_license_type($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_license_type = $api_search_solr->get_data_by_groups('license_type', 'license_type ASC');
        $this->filter_license_type = $data_groups_license_type->license_type->groups;
    }

    protected function load_contributors($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_author = $api_search_solr->get_data_by_groups('author', 'author ASC');
        $this->filter_contributors = $data_groups_author->author->groups;
    }

    protected function load_dok($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_dok = $api_search_solr->get_data_by_groups('dok', 'dok ASC');
        $this->filter_dok = $data_groups_dok->dok->groups;
    }


    protected function load_ranking($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_ranking = $api_search_solr->get_data_by_groups('ratings', 'ratings ASC', false);
        $this->filter_ranking = $data_groups_ranking->ratings->groups;
    }

    protected function load_standards($c)
    {
        $api_search_solr = new WiseWireApiSearch($c);
        $data_groups_standard = $api_search_solr->get_data_by_groups('standard', 'standard ASC');
        $this->filter_standards = $data_groups_standard->standard->groups;
    }

    protected function load_data_to_filters()
    {
        if ($this->search !== false && !$this->search) {
            return false;
        }

        $conditions = $this->get_filters(); // $this->search ? false : true
        $this->load_grades($conditions);
        $this->load_subdisciplines($conditions);
        $this->load_content_types($conditions);
        $this->load_object_types($conditions);
        $this->load_contributors($conditions);
        $this->load_dok($conditions);
        $this->load_ranking($conditions);
        $this->load_standards($conditions);
        $this->load_license_type($conditions);
    }
}
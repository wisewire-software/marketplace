SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for platform_category_levels
-- ----------------------------
DROP TABLE IF EXISTS `platform_category_levels`;
CREATE TABLE `platform_category_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `category_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level1_term` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level1_label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level2_term` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level2_label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level3_term` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level3_label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level4_term` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level4_label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level5_term` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level5_label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;


create index idx_plat_cat_levels_01 on platform_category_levels(category_id, category_type);



#################################   29-12-2015  ##########################################

/* table wp_apicache_items*/

ALTER TABLE `wp_apicache_items` CHANGE `source` `source` INT(11) NOT NULL DEFAULT '1' COMMENT '1:platform, 2: merlot';


/* search tile*/
CREATE TABLE `tmp_platform_cc_info` (
  `itemId` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level2_label` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level3_label` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `idx_tmp_platform_cc_info_01` (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `tmp_platform_dis_info` (
  `itemId` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level1_label` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `idx_tmp_platform_dis_info_01` (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `platform_item_tile_info` (
  `itemId` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cc_level2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cc_level3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cc_code` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dis_level1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  KEY `idx_plat_itm_til_inf_01` (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/** procedure for search optimization **/

DROP PROCEDURE IF EXISTS wordpress.prc_populate_platform_tile_info;
DELIMITER $$
CREATE PROCEDURE wordpress.`prc_populate_platform_tile_info`()
begin

  truncate table tmp_platform_cc_info;

  insert into tmp_platform_cc_info(itemId, level2_label,level3_label, code) 
  select
      distinct
          catcc.itemId,
          ccc.level2_label,
          ccc.level3_label,
          ccc.code            
        from
        wp_apicache_categories catcc
        inner join wp_terms tcc on tcc.term_id = catcc.term_id
        inner join platform_category_levels ccc on ccc.category_id = tcc.api_id and ccc.category_type = 'Common Core'
        inner join wp_apicache_items i on i.itemId = catcc.itemId
  where i.type = 'item' and i.source = 1;
  
  truncate table tmp_platform_dis_info;

  insert into tmp_platform_dis_info(itemId, level1_label)
   select
         distinct catdis.itemId, cdis.level1_label
        from
          wp_apicache_categories catdis 
          inner join wp_terms tdis on tdis.term_id = catdis.term_id
          inner join platform_category_levels cdis on cdis.category_id = tdis.api_id and cdis.category_type = 'Discipline'
          inner join wp_apicache_items i on i.itemId = catdis.itemId
  where i.type = 'item' and i.source = 1;


  truncate table platform_item_tile_info;

  insert into platform_item_tile_info(itemId, cc_level2, cc_level3, cc_code, dis_level1)
  select 
        p.itemId,
       catcc.level2_label as cc_level2,
       catcc.level3_label as cc_level3,
       catcc.code as cc_code,
       cdis.level1_label as dis_level1
  from
  `wp_apicache_items` p
    left join tmp_platform_cc_info catcc on catcc.itemId = p.itemId
    left join tmp_platform_dis_info cdis on cdis.itemId = p.itemId
  where p.type = 'item' and p.source = 1;
end;$$
DELIMITER ;



/** ADD custom field for url video in publish page  **/
INSERT INTO `wp_posts` (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ('51', '2015-12-29 21:34:28', '2015-12-29 21:34:28', 'a:12:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:8:\"readonly\";i:0;s:8:\"disabled\";i:0;}', 'url video', 'url_video', 'publish', 'closed', 'closed', '', 'field_5682fc3bcfacb', '', '', '2015-12-29 21:34:28', '2015-12-29 21:34:28', '', '363', 'http://wisewire.local/?post_type=acf-field&p=14431', '8', 'acf-field', '', '0');



/*******************************************  30-12-2015  ********************************************************/

/*
#######################################################################
-- FILE: 20151228_create_tables.sql
--
-- DESCRIPTION: SCRIPT TO MAP MERLOT CATEGORIES AGAINST PLATFORM CATEGORIES
--
-- DATABASE/SCHEMA : wordpress
--
-- INPUTS: no required
--
-- OUTPUTS: 
--
-- VARIABLES: no required
--
--
-- DATE     NAME        DESCRIPTION
-- YYYYMMDD
-- -------- ----------- -------------------------------------------------
-- 20151229  ogutierrez      CREATED
--#######################################################################
*/

-- create mapping table for disciplines

create table ww_merlot_discipline_map(
  `ml_discipline` varchar(255) ,
  `ml_subdiscipline` varchar(255) ,
    `ww_discipline` varchar(255) ,
    `ww_subdiscipline` varchar(255),
    `category_id` int(11)
);

-- insert equivalence 

insert into ww_merlot_discipline_map (`ml_discipline`,`ml_subdiscipline`,`ww_discipline`,`ww_subdiscipline`) values 
  ('Academic Support Services','Accessibility','professional-and-career','professional-development'),
    ('Academic Support Services','Accreditation','professional-and-career','professional-development'),
    ('Academic Support Services','Career Counseling and Services','professional-and-career','professional-development'),
    ('Academic Support Services','Content Repositories','professional-and-career','professional-development'),
    ('Academic Support Services','Course Redesign','professional-and-career','professional-development'),
    ('Academic Support Services','Degree Completion or Accelerating Graduation','professional-and-career','professional-development'),
    ('Academic Support Services','Eportfolios','professional-and-career','professional-development'),
    ('Academic Support Services','Faculty Development','professional-and-career','professional-development'),
    ('Academic Support Services','Hybrid and Online Course Development','professional-and-career','professional-development'),
    ('Academic Support Services','ICT (Information and Communication Technology)','professional-and-career','information-technology'),
    ('Academic Support Services','Institutional Research on Technology Use','professional-and-career','trades-and-technology'),
    ('Academic Support Services','K-20 Initiatives','professional-and-career','professional-development'),
    ('Academic Support Services','LMS Planning and Implementation','professional-and-career','professional-development'),
    ('Academic Support Services','Leadership Library','professional-and-career','professional-development'),
    ('Academic Support Services','Library and Information Services','professional-and-career','professional-development'),
    ('Academic Support Services','Mobile Learning','professional-and-career','professional-development'),
    ('Academic Support Services','Online Degree Program Development','professional-and-career','professional-development'),
    ('Academic Support Services','Open Education','professional-and-career','professional-development'),
    ('Academic Support Services','Other Innovations or Emerging Technologies','professional-and-career','trades-and-technology'),
    ('Academic Support Services','Scholarship of Teaching and Learning','professional-and-career','professional-development'),
    ('Academic Support Services','Smart Classrooms','professional-and-career','professional-development'),
    ('Academic Support Services','Staff Development','professional-and-career','professional-development'),
    ('Academic Support Services','Textbook Affordability','professional-and-career','professional-development'),
    ('Academic Support Services','Virtual Environments','professional-and-career','trades-and-technology'),
    ('Arts','Architecture','humanities-social-sciences','interdisciplinary'),
    ('Arts','Art Education','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Art History','humanities-social-sciences','history'),
    ('Arts','Ceramics','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Cinema','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Dance','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Design','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Drawing and Painting','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Fiber','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Film, Video, and Electronic Arts','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Fine Arts','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','General','humanities-social-sciences','interdisciplinary'),
    ('Arts','Graphic Design, Illustration and Animation','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Metal and Jewelry','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Music','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Photography','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Printmaking','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Sculpture','humanities-social-sciences','music-and-fine-arts'),
    ('Arts','Theatre','humanities-social-sciences','music-and-fine-arts'),
    ('Business','Accounting','professional-and-career','business-management'),
    ('Business','Business Law','professional-and-career','business-management'),
    ('Business','Corporate Social Responsibility','professional-and-career','business-management'),
    ('Business','E-Commerce','professional-and-career','business-management'),
    ('Business','Economics','professional-and-career','economics'),
    ('Business','Finance','professional-and-career','business-management'),
    ('Business','General','professional-and-career','business-management'),
    ('Business','Information Systems','professional-and-career','information-technology'),
    ('Business','International Business','professional-and-career','business-management'),
    ('Business','Management','professional-and-career','business-management'),
    ('Business','Marketing','professional-and-career','business-management'),
    ('Business','Professional Coaching','professional-and-career','business-management'),
    ('Education','Digital Citizenship','professional-and-career','professional-development'),
    ('Education','Educational Leadership','professional-and-career','professional-development'),
    ('Education','General','professional-and-career','professional-development'),
    ('Education','Teacher Ed','professional-and-career','professional-development'),
    ('Humanities','Africana or African American or Black Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','American Indian or Native American Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','American Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','Asian or Asian American Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','Chicana or Latina Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','Chicano or Latino Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','Communication Studies','humanities-social-sciences','english'),
    ('Humanities','Comparative Literature and Classics','humanities-social-sciences','english'),
    ('Humanities','English','humanities-social-sciences','english'),
  ('Humanities','European Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','General','humanities-social-sciences','interdisciplinary'),
    ('Humanities','History','humanities-social-sciences','history'),
    ('Humanities','Indigenous Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','Jewish Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','Journalism','professional-and-career','journalism'),
    ('Humanities','Philosophy','humanities-social-sciences','philosophy'),
    ('Humanities','Religious Studies','humanities-social-sciences','religion'),
    ('Humanities','Sexuality Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','South West Asian North African (SWANA) American','humanities-social-sciences','interdisciplinary'),
    ('Humanities','Women and Gender Studies','humanities-social-sciences','interdisciplinary'),
    ('Humanities','World Languages','humanities-social-sciences','world-languages'),
    ('Mathematics and Statistics','Mathematics','mathematics',null),
    ('Mathematics and Statistics','Statistics and Probability','mathematics','statistics-and-probability'),
    ('Science and Technology','Agriculture and Environmental Sciences','science','environmental-science'),
    ('Science and Technology','Astronomy','science','physics-and-astronomy'),
    ('Science and Technology','Biology','science','biology'),
    ('Science and Technology','Chemistry','science','chemistry'),
    ('Science and Technology','Communication Sciences and Disorders','professional-and-career','allied-health'),
    ('Science and Technology','Computer Science','professional-and-career','computer-science'),
    ('Science and Technology','Engineering','professional-and-career','engineering'),
    ('Science and Technology','General Science','science',null),
    ('Science and Technology','Geoscience','science','geography-and-atmospheric-sciences'),
    ('Science and Technology','Health Sciences','science','health-and-nutrition'),
    ('Science and Technology','Information Technology','professional-and-career','information-technology'),
    ('Science and Technology','Kinesiology','science','anatomy-physiology'),
    ('Science and Technology','Nanotechnology','professional-and-career','trades-and-technology'),
    ('Science and Technology','Physics','science','physics-and-astronomy'),
    ('Social Sciences','Anthropology','humanities-social-sciences','anthropology'),
    ('Social Sciences','Archaeology','humanities-social-sciences','anthropology'),
    ('Social Sciences','Criminal Justice','professional-and-career','law-and-criminal-justice'),
    ('Social Sciences','Environmental Studies','humanities-social-sciences','interdisciplinary'),
    ('Social Sciences','General','humanities-social-sciences','interdisciplinary'),
    ('Social Sciences','Geography','science','geography-and-atmospheric-sciences'),
    ('Social Sciences','Law','professional-and-career','law-and-criminal-justice'),
    ('Social Sciences','Linguistics','humanities-social-sciences','anthropology'),
    ('Social Sciences','Political Science','humanities-social-sciences','political-science'),
    ('Social Sciences','Psychology','humanities-social-sciences','psychology'),
    ('Social Sciences','Social Work','humanities-social-sciences','psychology'),
    ('Social Sciences','Sociology','humanities-social-sciences','sociology'),
    ('Social Sciences','Sports and Games','humanities-social-sciences','interdisciplinary'),
    ('Social Sciences','Statistics','mathematics','statistics-and-probability'),
    ('Workforce Development','Application Development','professional-and-career','trades-and-technology'),
    ('Workforce Development','Construction','professional-and-career','trades-and-technology'),
    ('Workforce Development','Fire Safety','professional-and-career','ems-safety'),
    ('Workforce Development','Homeland Security','professional-and-career','ems-safety'),
    ('Workforce Development','Hospitality and Tourism','professional-and-career','business-management'),
    ('Workforce Development','Industrial Education/Career Technical Education','professional-and-career','trades-and-technology'),
    ('Workforce Development','Technical Allied Health','professional-and-career','allied-health'),
    ('Workforce Development','Transportation, Distribution, and Logistics','professional-and-career','trades-and-technology');

-- Update category_id by terms

UPDATE ww_merlot_discipline_map m 
  JOIN platform_category_levels p
  ON m.ww_discipline = p.level1_term 
  AND m.ww_subdiscipline = p.level2_term
SET m.category_id = p.category_id
WHERE p.category_type = 'Discipline';

-- create mapping table for student level
    
create table ww_merlot_grade_map(
  `ml_audience` varchar(255) ,
    `ww_level_one` varchar(255) ,
    `ww_level_two` varchar(255),
    `category_id` int(11)
);

-- insert equivalence

insert into ww_merlot_grade_map (`ml_audience`,`ww_level_one`,`ww_level_two`) values 
  ('Grade School','primary-school','first-grade'),
    ('Grade School','primary-school','second-grade'),
    ('Grade School','primary-school','third-grade'),
    ('Grade School','primary-school','fourth-grade'),
    ('Grade School','primary-school','fifth-grade'),
    ('College Lower Division','higher-education','undergraduate'),
    ('Middle School','primary-school','sixth-grade'),
    ('Middle School','primary-school','seventh-grade'),
    ('Middle School','primary-school','eighth-grade'),
    ('College Upper Division','higher-education','graduate'),
    ('High School','high-school','ninth-grade'),
    ('High School','high-school','tenth-grade'),
    ('High School','high-school','eleventh-grade'),
    ('High School','high-school','twelfth-grade'),
    ('Graduate School','higher-education','graduate'),
    ('College General Ed','higher-education','undergraduate'),
    ('Professional','higher-education','graduate');

-- Update category_id by terms

UPDATE ww_merlot_grade_map m 
  JOIN platform_category_levels p
  ON m.ww_level_one = p.level1_term 
  AND m.ww_level_two = p.level2_term
SET m.category_id = p.category_id
WHERE p.category_type = 'Student Level';


/* add new column to this table to indicate the source of the categories*/

ALTER TABLE `wp_apicache_categories`
ADD COLUMN `source`  int NOT NULL DEFAULT 1 COMMENT '1: Platform, 2:Merlot' AFTER `term_id`;


ALTER TABLE `wp_apicache_items`
MODIFY COLUMN `contentType`  varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL AFTER `itemId`;




/*
#######################################################################
-- FILE: 20160114_summarized_items_table.sql
--
-- DESCRIPTION: Populate table to store summarized data of questions from CMS, Platform and Merlot.
--
-- DATABASE/SCHEMA : wordpress
--
-- INPUTS: no required
--
-- OUTPUTS: 
--
-- VARIABLES: no required
--
--
-- DATE     NAME        DESCRIPTION
-- YYYYMMDD
-- -------- ----------- -------------------------------------------------
-- 20160114  ogutierrez      CREATED
--#######################################################################
*/


DROP TABLE IF EXISTS `summarized_item_metadata`;
CREATE TABLE `summarized_item_metadata`(
    `id` varchar(42),
    `author` varchar(200) COLLATE utf8mb4_unicode_ci,
    `date` datetime,
    `title` mediumtext COLLATE utf8mb4_unicode_ci,
    `name` varchar(200) COLLATE utf8mb4_unicode_ci,
    `type` varchar(20) COLLATE utf8mb4_unicode_ci,
    `publish_date` datetime,
    `content_type_icon` longtext,
    `object_type` longtext,
    `ratings` longtext,
    `preview` longtext,
    `dok` longtext,
    `grade` longtext,
    `grade_id` longtext,
    `subdiscipline` longtext,
    `preview_url` varchar(512),
    `source` varchar(8),
    `description` mediumtext COLLATE utf8mb4_unicode_ci,
    `level1_label` varchar(200),
    `level2_label` varchar(200),
    `level3_label` varchar(200),
    `description_label` mediumtext COLLATE utf8mb4_unicode_ci,
    `code_label` varchar(200),
    `tags` longtext COLLATE utf8mb4_unicode_ci,
    `image_id` longtext COLLATE utf8mb4_unicode_ci,
     dis_id int,
     dis_slug longtext COLLATE utf8mb4_unicode_ci,
     standard longtext COLLATE utf8mb4_unicode_ci,
     views int
);


DROP PROCEDURE IF EXISTS wordpress.prc_populate_summarized_item_metadata;

DELIMITER $$

CREATE PROCEDURE wordpress.`prc_populate_summarized_item_metadata`()
BEGIN

  TRUNCATE TABLE `summarized_item_metadata`;
    
  INSERT INTO `summarized_item_metadata`
SELECT 
      p.`ID` as `id`,
      (select trim(meta_value) from wp_postmeta where post_id = p.id and meta_key = 'item_contributor') as `author`,
        STR_TO_DATE(p.`post_date`, '%Y%m%d %T') as `date`,
        p.`post_title` as `title`,
        p.`post_name` as `name`,
        p.`post_type` as `type`,(SELECT 
            STR_TO_DATE(ipd.meta_value, '%Y%m%d %T')
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_publish_date'
          LIMIT 1) AS `publish_date`,
        (SELECT 
            ipd.meta_value
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_content_type_icon'
          LIMIT 1) AS `content_type_icon`,
        (SELECT 
            ipd.meta_value
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_object_type'
          LIMIT 1) AS `object_type`,
        (SELECT 
            ipd.meta_value
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_ratings'
          LIMIT 1) AS `ratings`,
        (SELECT 
            ipd.meta_value
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_preview'
          LIMIT 1) AS `preview`,
        (SELECT 
            ipd.meta_value
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_dok'
          LIMIT 1) AS `dok`,
        (SELECT 
            GROUP_CONCAT(DISTINCT t.`name` ORDER BY t.`term_id` SEPARATOR ',')
          FROM
            `wp_term_relationships` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Student Level'
            AND t.`term_id` = tr.`term_taxonomy_id`           
          WHERE
            tr.`object_id` = p.`ID` and t.api_branch = 2
        ) AS `grades`,    
        (SELECT 
            GROUP_CONCAT(DISTINCT t.`term_id` ORDER BY t.`term_id` SEPARATOR ',')
          FROM
            `wp_term_relationships` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Student Level'
            AND t.`term_id` = tr.`term_taxonomy_id`           
          WHERE
            tr.`object_id` = p.`ID` and t.api_branch = 2
        ) AS `grades_id`,    
        (SELECT 
            t.`name`
          FROM
            `wp_term_relationships` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline'
            AND t.`term_id` = tr.`term_taxonomy_id`           
          WHERE
            tr.`object_id` = p.`ID` and t.api_branch = 2
          LIMIT 1) AS `subdiscipline`,
        null AS `preview_url`,
        'CMS' AS `source`,
        (SELECT 
            ipd.meta_value
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_long_description'
          LIMIT 1) AS description,
        (SELECT 
          t.`name`
          FROM
            `wp_term_relationships` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline'
            AND t.`term_id` = tr.`term_taxonomy_id`           
        WHERE
          tr.`object_id` = p.`ID` and t.api_branch = 1
        LIMIT 1) AS `level1_label`,
        null AS `level2_label`,
        null AS `level3_label`,
        null AS `description_label`,
        null AS `code_label`,
        (SELECT 
            REPLACE(ipd.meta_value,'; ',',')
          FROM
            wp_postmeta ipd
          WHERE
            ipd.post_id = p.ID
              AND ipd.meta_key = 'item_keywords'
          LIMIT 1) AS `tags`,
        (select pm.meta_value FROM wp_postmeta pm WHERE pm.meta_key = 'item_main_image' and pm.post_id = p.`ID` limit 1)  AS `image_id`,
              (SELECT 
          t.`term_id`
          FROM
            `wp_term_relationships` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline'
            AND t.`term_id` = tr.`term_taxonomy_id`           
        WHERE
          tr.`object_id` = p.`ID` and t.api_branch = 1
        LIMIT 1) as dis_id,
        (SELECT 
          t.`slug`
          FROM
            `wp_term_relationships` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline'
            AND t.`term_id` = tr.`term_taxonomy_id`           
        WHERE
          tr.`object_id` = p.`ID` and t.api_branch = 1
        LIMIT 1) as dis_slug,  
        (
            SELECT
              GROUP_CONCAT(DISTINCT t.`name` ORDER BY t.`name` SEPARATOR ',')
            FROM
              wp_term_relationships r 
              INNER JOIN wp_term_taxonomy tt ON tt.`term_taxonomy_id` = r.`term_taxonomy_id` 
              INNER JOIN wp_terms t ON t.`term_id` = tt.`term_id`
            WHERE
              r.`object_id` = p.`ID` AND tt.`taxonomy` = 'Standards'
)as standard,
  (select count(*) from wp_object_views ov 
           where ov.post_id = p.`ID`) views
    FROM
      wp_posts p         
    WHERE 
      p.`post_type` = 'item'
        AND p.`post_status` = 'publish';

    INSERT INTO `summarized_item_metadata`
    SELECT 
      p.`itemId` AS `id`,
        trim(p.`userFullName`) AS `author`,
        p.`created` AS `date`,
        p.`title` AS `title`,
        null AS `name`,
        'pod' AS `type`,
        p.`created` AS `publish_date`,
        (CASE 
          WHEN p.`source` = 1 THEN 'Assessment'
          WHEN p.`source` = 2 THEN p.contentType
          ELSE null
        END) AS `content_type_icon`,
        (CASE
          WHEN p.`itemType` LIKE 'standard' AND p.`source` = 1 THEN 'assessment'
          ELSE p.`itemType`
        END) AS `object_type`,
        (SELECT 
            cm.meta_value
          FROM
            wp_apicache_meta cm
          WHERE
            cm.itemId = p.itemId
              AND cm.meta_key = 'item_ratings'
          LIMIT 1) AS item_ratings,
        IF(p.`previewURL` != '', 'Y', 'N') AS `item_preview`,
        p.`dok` AS `dok`,
        (SELECT 
            GROUP_CONCAT(DISTINCT t.`name` ORDER BY t.`term_id` SEPARATOR ',')
          FROM
            `wp_apicache_categories` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Student Level'
            AND t.`term_id` = tr.`categoryId`
          WHERE
            tr.`itemId` = p.itemId and t.api_branch = 2
        ) AS `grades`,    
        (SELECT 
            REPLACE(GROUP_CONCAT(DISTINCT t.`term_id` ORDER BY t.`term_id` SEPARATOR ','),';',',')
          FROM
            `wp_apicache_categories` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Student Level'
            AND t.`term_id` = tr.`categoryId`
          WHERE
            tr.`itemId` = p.itemId and t.api_branch = 2
        ) AS `grades_id`,    
        (SELECT 
            t.`name`
          FROM
            `wp_apicache_categories` tr
          INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline'
            AND t.`term_id` = tr.`categoryId`
          WHERE
            tr.`itemId` = p.itemId and t.api_branch = 2
          LIMIT 1) AS `subdiscipline`,
        p.`previewURL` as `preview_url`,
        (CASE 
          WHEN p.`source` = 1 THEN 'PLATFORM'
          WHEN p.`source` = 2 THEN 'MERLOT'
          ELSE null
        END) AS `source`,
        p.description,
        pitl.`dis_level1` AS `level1_label`,
        pitl.`cc_level2` AS `level2_label`,
        pitl.`cc_level3` AS `level3_label`,
        p.`description` AS `description_label`,
        pitl.`cc_code` AS `code_label`,
        (SELECT GROUP_CONCAT(DISTINCT apt.tag SEPARATOR ',')
          FROM
            wp_apicache_tags apt
          WHERE
            apt.itemId = p.itemId
        ) AS `tags`,
        null as `image_id`,
        pitl.dis_term_id,
        pitl.dis_slug,
        null as standard,
        (select count(*) from wp_object_views ov 
           where ov.object_id = p.`itemId`) views
    FROM
      `wp_apicache_items` p
    LEFT JOIN `platform_item_tile_info` pitl ON pitl.itemId = p.itemId;
END $$


DELIMITER ;



ALTER TABLE `wp_apicache_items`
ADD COLUMN `price`  decimal(15,2) NOT NULL AFTER `source`,
ADD COLUMN `license_type`  bigint(20) NOT NULL AFTER `price`;



##################################################################################
################################# JUNE 20th  #####################################
##################################################################################

ALTER TABLE `summarized_item_metadata`
ADD COLUMN `license_type`  varchar(100) NULL AFTER `views`;



#################### SEPTEMBER 21th ###############################

ALTER TABLE `wp_postmeta`
ADD INDEX `meta_value` (`meta_value`(100)) USING BTREE ;
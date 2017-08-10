CREATE PROCEDURE `prc_populate_summarized_of_platform`(IN `item_id` varchar(225))
BEGIN
	SET @query_summarized = '';
	SET @query_where  = '';
	SET @quey_delete_summarized = ''; 

	SET @query_summarized = "INSERT INTO summarized_item_metadata SELECT
											p.itemId AS id,
											trim(p.userFullName) AS author,
											p.created AS date,
											p.title AS title,
											NULL AS NAME,
											'pod' AS type,
											p.created AS publish_date,
											(
												CASE
												WHEN p.source = 1 THEN
													'Assessment'
												WHEN p.source = 2 THEN
													p.contentType
												ELSE
													NULL
												END
											) AS content_type_icon,
											(
												CASE
												WHEN p.itemType LIKE 'standard'
												AND p.source = 1 THEN
													'assessment'
												ELSE
													p.itemType
												END
											) AS object_type,
											(
												SELECT
													cm.meta_value
												FROM
													wp_apicache_meta cm
												WHERE
													cm.itemId = p.itemId
												AND cm.meta_key = 'item_ratings'
												LIMIT 1
											) AS item_ratings,

										IF (p.previewURL != '', 'Y', 'N') AS item_preview,
										 p.dok AS dok,
										 (
											SELECT
												GROUP_CONCAT(
													DISTINCT t. NAME
													ORDER BY
														t.term_id SEPARATOR ','
												)
											FROM
												wp_apicache_categories tr
											INNER JOIN wp_terms t ON t.api_type = 'Student Level'
											AND t.term_id = tr.categoryId
											WHERE
												tr.itemId = p.itemId
											AND t.api_branch = 2
										) AS grades,
										 (
											SELECT
												REPLACE (
													GROUP_CONCAT(
														DISTINCT t.term_id
														ORDER BY
															t.term_id SEPARATOR ','
													),
													';',
													','
												)
											FROM
												wp_apicache_categories tr
											INNER JOIN wp_terms t ON t.api_type = 'Student Level'
											AND t.term_id = tr.categoryId
											WHERE
												tr.itemId = p.itemId
											AND t.api_branch = 2
										) AS grades_id,
										 (
											SELECT
												t. NAME
											FROM
												wp_apicache_categories tr
											INNER JOIN wp_terms t ON t.api_type = 'Discipline'
											AND t.term_id = tr.categoryId
											WHERE
												tr.itemId = p.itemId
											AND t.api_branch = 2
											LIMIT 1
										) AS subdiscipline,
										 p.previewURL AS preview_url,
										 (
											CASE
											WHEN p.source = 1 THEN
												'PLATFORM'
											WHEN p.source = 2 THEN
												'MERLOT'
											ELSE
												NULL
											END
										) AS source,
										 p.description,
										 pitl.dis_level1 AS level1_label,
										 pitl.cc_level2 AS level2_label,
										 pitl.cc_level3 AS level3_label,
										 p.description AS description_label,
										 pitl.cc_code AS code_label,
										 (
											SELECT
												GROUP_CONCAT(
													DISTINCT apt.tag SEPARATOR ','
												)
											FROM
												wp_apicache_tags apt
											WHERE
												apt.itemId = p.itemId
										) AS tags,
										 NULL AS image_id,
										 pitl.dis_term_id,
										 pitl.dis_slug,
										 NULL AS standard,
										 (
											SELECT
												count(*)
											FROM
												wp_object_views ov
											WHERE
												ov.object_id = p.itemId
										) views,
										 (
											CASE
											WHEN p.license_type = 1 THEN
												'ALL-RIGHTS-RESERVED'
											WHEN p.license_type = 2 THEN
												'CC BY'
											WHEN p.license_type = 3 THEN
												'CC BY-SA'
											WHEN p.license_type = 4 THEN
												'CC BY-ND'
											WHEN p.license_type = 5 THEN
												'CC BY-NC'
											WHEN p.license_type = 6 THEN
												'CC BY-NC-SA'
											WHEN p.license_type = 7 THEN
												'CC BY-NC-ND'
											ELSE
												'No information'
											END
										) AS license_type,
										 NOW() AS last_modified
										FROM
											wp_apicache_items p
										LEFT JOIN wp_apicache_meta pm ON p.itemId = pm.itemId AND pm.meta_key = 'is_hide_item'
										LEFT JOIN platform_item_tile_info pitl ON pitl.itemId = p.itemId
										WHERE pm.meta_value = 0";


	IF item_id  IS NOT NULL THEN
		SET @query_where = CONCAT(" AND p.itemId = '",item_id,"'");
		SET @quey_delete_summarized = CONCAT("DELETE FROM summarized_item_metadata WHERE id = '",item_id ,"'");

		PREPARE stmt_delete FROM @quey_delete_summarized;
		EXECUTE stmt_delete;
	END IF;

	SET @query_summarized = CONCAT(@query_summarized, @query_where);

	PREPARE stmt FROM @query_summarized;
	EXECUTE stmt;

END;


CREATE PROCEDURE `prc_populate_summarized_of_cms`(IN `item_id` varchar(225))
BEGIN
	SET @query_summarized = '';
	SET @query_where  = '';
	SET @quey_delete_summarized = ''; 

	SET @query_summarized = "INSERT INTO summarized_item_metadata SELECT
													p.ID AS id,
													(
														SELECT
															trim(meta_value)
														FROM
															wp_postmeta
														WHERE
															post_id = p.id
														AND meta_key = 'item_contributor'
													) AS author,
													STR_TO_DATE(p.post_date, '%Y%m%d %T') AS date,
													p.post_title AS title,
													p.post_name AS name,
													p.post_type AS type,
													(
														SELECT
															STR_TO_DATE(ipd.meta_value, '%Y%m%d %T')
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_publish_date'
														LIMIT 1
													) AS publish_date,
													(
														SELECT
															ipd.meta_value
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_content_type_icon'
														LIMIT 1
													) AS content_type_icon,
													(
														SELECT
															ipd.meta_value
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_object_type'
														LIMIT 1
													) AS object_type,
													(
														SELECT
															ipd.meta_value
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_ratings'
														LIMIT 1
													) AS ratings,
													(
														SELECT
															ipd.meta_value
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_preview'
														LIMIT 1
													) AS preview,
													(
														SELECT
															ipd.meta_value
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_dok'
														LIMIT 1
													) AS dok,
													(
														SELECT
															GROUP_CONCAT(
																DISTINCT t.name
																ORDER BY
																	t.term_id SEPARATOR ','
															)
														FROM
															wp_term_relationships tr
														INNER JOIN wp_terms t ON t.api_type = 'Student Level'
														AND t.term_id = tr.term_taxonomy_id
														WHERE
															tr.object_id = p.ID
														AND t.api_branch = 2
													) AS grades,
													(
														SELECT
															GROUP_CONCAT(
																DISTINCT t.term_id
																ORDER BY
																	t.term_id SEPARATOR ','
															)
														FROM
															wp_term_relationships tr
														INNER JOIN wp_terms t ON t.api_type = 'Student Level'
														AND t.term_id = tr.term_taxonomy_id
														WHERE
															tr.object_id = p.ID
														AND t.api_branch = 2
													) AS grades_id,
													(
														SELECT
															t.name
														FROM
															wp_term_relationships tr
														INNER JOIN wp_terms t ON t.api_type = 'Discipline'
														AND t.term_id = tr.term_taxonomy_id
														WHERE
															tr.object_id = p.ID
														AND t.api_branch = 2
														LIMIT 1
													) AS subdiscipline,
													NULL AS preview_url,
													'CMS' AS source,
													(
														SELECT
															ipd.meta_value
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_long_description'
														LIMIT 1
													) AS description,
													(
														SELECT
															t.name
														FROM
															wp_term_relationships tr
														INNER JOIN wp_terms t ON t.api_type = 'Discipline'
														AND t.term_id = tr.term_taxonomy_id
														WHERE
															tr.object_id = p.ID
														AND t.api_branch = 1
														LIMIT 1
													) AS level1_label,
													NULL AS level2_label,
													NULL AS level3_label,
													NULL AS description_label,
													NULL AS code_label,
													(
														SELECT
															REPLACE (ipd.meta_value, '; ', ',')
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_keywords'
														LIMIT 1
													) AS tags,
													(
														SELECT
															pm.meta_value
														FROM
															wp_postmeta pm
														WHERE
															pm.meta_key = 'item_main_image'
														AND pm.post_id = p.ID
														LIMIT 1
													) AS image_id,
													(
														SELECT
															t.term_id
														FROM
															wp_term_relationships tr
														INNER JOIN wp_terms t ON t.api_type = 'Discipline'
														AND t.term_id = tr.term_taxonomy_id
														WHERE
															tr.object_id = p.ID
														AND t.api_branch = 1
														LIMIT 1
													) AS dis_id,
													(
														SELECT
															t.slug
														FROM
															wp_term_relationships tr
														INNER JOIN wp_terms t ON t.api_type = 'Discipline'
														AND t.term_id = tr.term_taxonomy_id
														WHERE
															tr.object_id = p.ID
														AND t.api_branch = 1
														LIMIT 1
													) AS dis_slug,
													(
														SELECT
															GROUP_CONCAT(
																DISTINCT t.name
																ORDER BY
																	t.name SEPARATOR ','
															)
														FROM
															wp_term_relationships r
														INNER JOIN wp_term_taxonomy tt ON tt.term_taxonomy_id = r.term_taxonomy_id
														INNER JOIN wp_terms t ON t.term_id = tt.term_id
														WHERE
															r.object_id = p.ID
														AND tt.taxonomy = 'Standards'
													) AS standard,
													(
														SELECT
															count(*)
														FROM
															wp_object_views ov
														WHERE
															ov.post_id = p.ID
													) views,
													(
														SELECT
															(
																CASE
																WHEN ipd.meta_value = ''
																OR ipd.meta_value = NULL THEN
																	'No information'
																ELSE
																	ipd.meta_value
																END
															)
														FROM
															wp_postmeta ipd
														WHERE
															ipd.post_id = p.ID
														AND ipd.meta_key = 'item_license_type'
														LIMIT 1
													) AS license_type,
													NOW() AS last_modified
												FROM
													wp_posts p
												LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'is_hide_item'
												WHERE p.post_type = 'item' AND p.post_status = 'publish' AND pm.meta_value = 0";


	IF item_id  IS NOT NULL THEN
		SET @query_where = CONCAT(" AND p.id = '",item_id,"'");
		SET @quey_delete_summarized = CONCAT("DELETE FROM summarized_item_metadata WHERE id = '",item_id ,"'");

		PREPARE stmt_delete FROM @quey_delete_summarized;
		EXECUTE stmt_delete;
	END IF;

	SET @query_summarized = CONCAT(@query_summarized, @query_where);

	PREPARE stmt FROM @query_summarized;
	EXECUTE stmt;

END;

CREATE PROCEDURE `prc_populate_summarized_item_metadata`()
BEGIN
	TRUNCATE TABLE `summarized_item_metadata`;  
	CALL prc_populate_summarized_of_cms(NULL);
	CALL prc_populate_summarized_of_platform(NULL); 
END;




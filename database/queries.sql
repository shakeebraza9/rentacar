ALTER TABLE `product_categories` ADD `is_featured` INT NULL DEFAULT '0' AFTER `is_enable`;





INSERT INTO `settings` (`id`, `field`, `value`, `type`, `sort`, `grouping`) 
VALUES (NULL, 'site_currency', 'Erha Wear', 'text', '5', 'site_settings');

ALTER TABLE `menu_items` ADD CONSTRAINT `menu_parent_id_relation` 
FOREIGN KEY (`menu_id`) REFERENCES `menus`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `menus` ADD `slug` VARCHAR(255) NULL DEFAULT NULL AFTER `title`;

INSERT INTO `settings` (`id`, `field`, `value`, `type`, `sort`, `grouping`) 
VALUES (NULL, 'topbar_title', 'Welcome To Irha wears', 'text', '1', 'site_settings');

INSERT INTO `settings` (`id`, `field`, `value`, `type`, `sort`, `grouping`) 
VALUES (NULL, 'site_short_details', 'Irha Wears', 'text', '1', 'site_settings');


INSERT INTO `settings` (`id`, `field`, `value`, `type`, `sort`, `grouping`) 
VALUES (NULL, 'home_page_banner', '', 'image', '1', 'site_settings');


ALTER TABLE `filemanager` ADD `grouping` TEXT NOT NULL DEFAULT 'others' AFTER `updated_at`;
ALTER TABLE `settings` ADD `section_sorting` INT NULL DEFAULT '0';
ALTER TABLE `settings` ADD `section` text NULL DEFAULT 'others';
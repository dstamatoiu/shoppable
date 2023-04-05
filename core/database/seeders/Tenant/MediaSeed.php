<?php

namespace Database\Seeders\Tenant;

use App\Helpers\SanitizeInput;
use App\Mail\TenantCredentialMail;
use App\Models\Admin;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Page;
use App\Models\PageBuilder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MediaSeed extends Seeder
{
    public function run()
    {
        // seeding media files into database
        $this->seedMediaUploaderFiles();

        // coping media
        $source_dir = 'assets/tenant/seeder_files/all-media';
        $destination_dir = 'assets/tenant/uploads/media-uploader/' . tenant()->id;
        $this->recursive_files_copy($source_dir, $destination_dir);
    }

    private function recursive_files_copy($source_dir, $destination_dir)
    {
        // Open the source folder / directory
        $dir = opendir($source_dir);

        // Create a destination folder / directory if not exist
        @mkdir($destination_dir, 0777, true);

        // Loop through the files in source directory
        while ($file = readdir($dir)) {
            // Skip . and ..
            if (($file != '.') && ($file != '..')) {
                // Check if it's folder / directory or file
                if (is_dir($source_dir . '/' . $file)) {
                    // Recursively calling this function for sub directory
                    $this->recursive_files_copy($source_dir . '/' . $file, $destination_dir . '/' . $file);
                } else {
                    // Copying the files
                    copy($source_dir . '/' . $file, $destination_dir . '/' . $file);
                }
            }
        }

        closedir($dir);
    }

    private function seedMediaUploaderFiles()
    {
        DB::statement("INSERT INTO `media_uploaders` (`id`, `title`, `path`, `alt`, `size`, `user_type`, `user_id`, `dimensions`, `created_at`, `updated_at`) VALUES
        (286,'store2.jpg','store21665821768.jpg',NULL,'43.42 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:08','2022-10-15 08:16:08'),
        (287,'store1.jpg','store11665821768.jpg',NULL,'46.63 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:08','2022-10-15 08:16:08'),
        (288,'store3.jpg','store31665821768.jpg',NULL,'43.51 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:08','2022-10-15 08:16:08'),
        (289,'store4.jpg','store41665821768.jpg',NULL,'29 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:08','2022-10-15 08:16:08'),
        (290,'store5.jpg','store51665821768.jpg',NULL,'47.39 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:08','2022-10-15 08:16:08'),
        (292,'store7.jpg','store71665821768.jpg',NULL,'36.6 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:08','2022-10-15 08:16:08'),
        (293,'store8.jpg','store81665821769.jpg',NULL,'39.6 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:09','2022-10-15 08:16:09'),
        (294,'s1.jpg','s11665821769.jpg',NULL,'31.57 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:09','2022-10-15 08:16:09'),
        (296,'s3.jpg','s31665821769.jpg',NULL,'48.96 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:09','2022-10-15 08:16:09'),
        (297,'s4.jpg','s41665821769.jpg',NULL,'70.41 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:09','2022-10-15 08:16:09'),
        (298,'s5.jpg','s51665821769.jpg',NULL,'29.78 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:09','2022-10-15 08:16:09'),
        (299,'s6.jpg','s61665821769.jpg',NULL,'160.95 KB',0,1,'405 x 405 pixels','2022-10-15 08:16:09','2022-10-15 08:16:09'),
        (300,'logo_01_theme.png','logo-01-theme1665822168.png',NULL,'1.97 KB',0,1,'139 x 28 pixels','2022-10-15 08:22:48','2022-10-15 08:22:48'),
        (301,'threme1.png','threme11665823414.png',NULL,'568.44 KB',0,1,'712 x 809 pixels','2022-10-15 08:43:34','2022-10-15 08:43:34'),
        (302,'01_theme_jacket_text.png','01-theme-jacket-text1665823522.png',NULL,'13.99 KB',0,1,'402 x 322 pixels','2022-10-15 08:45:22','2022-10-15 08:45:22'),
        (303,'01_theme_mask.png','01-theme-mask1665823547.png',NULL,'11.58 KB',0,1,'579 x 579 pixels','2022-10-15 08:45:47','2022-10-15 08:45:47'),
        (304,'grid-paypal16169347841650183083.png','grid-paypal161693478416501830831665833090.png',NULL,'25.53 KB',0,1,'350 x 156 pixels','2022-10-15 11:24:50','2022-10-15 11:24:50'),
        (305,'grid-mid16398240121650183083.png','grid-mid163982401216501830831665833149.png',NULL,'8.17 KB',0,1,'350 x 58 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (306,'grid-mercadopago-logo16438963701650183083.png','grid-mercadopago-logo164389637016501830831665833149.png',NULL,'21.7 KB',0,1,'350 x 91 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (307,'grid-mollie16169347831650183083.png','grid-mollie161693478316501830831665833149.png',NULL,'14.17 KB',0,1,'350 x 194 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (308,'grid-payfast-banner16398233581650183083.jpg','grid-payfast-banner163982335816501830831665833149.jpg',NULL,'8.8 KB',0,1,'350 x 164 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (310,'grid-payment-getway16169347831650183083.png','grid-payment-getway161693478316501830831665833149.png',NULL,'19.96 KB',0,1,'350 x 292 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (311,'grid-paystack16169347841650183083.jpg','grid-paystack161693478416501830831665833149.jpg',NULL,'8.75 KB',0,1,'350 x 97 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (312,'grid-paytm16169347841650183083.png','grid-paytm161693478416501830831665833149.png',NULL,'11.57 KB',0,1,'350 x 117 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (313,'grid-razorpay16169347851650183083.png','grid-razorpay161693478516501830831665833149.png',NULL,'16.48 KB',0,1,'350 x 210 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (314,'instamogo16398233571650183083.jpg','instamogo163982335716501830831665833149.jpg',NULL,'26.18 KB',0,1,'1200 x 675 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (315,'large-stripe161693478516496679721650183254.png','large-stripe1616934785164966797216501832541665833149.png',NULL,'175.53 KB',0,1,'740 x 370 pixels','2022-10-15 11:25:49','2022-10-15 11:25:49'),
        (316,'download.png','download1665833366.png',NULL,'5.79 KB',0,1,'402 x 125 pixels','2022-10-15 11:29:26','2022-10-15 11:29:26'),
        (317,'274277753_4842181969232427_5437853753661604973_n-modified.png','274277753-4842181969232427-5437853753661604973-n-modified1665833941.png',NULL,'209.45 KB',0,1,'322 x 322 pixels','2022-10-15 11:39:01','2022-10-15 11:39:01'),
        (318,'blog2.jpg','blog21665986714.jpg',NULL,'96.6 KB',0,1,'451 x 320 pixels','2022-10-17 06:05:14','2022-10-17 06:05:14'),
        (319,'blog1.jpg','blog11665986714.jpg',NULL,'79.95 KB',0,1,'450 x 320 pixels','2022-10-17 06:05:14','2022-10-17 06:05:14'),
        (320,'blog3.jpg','blog31665986714.jpg',NULL,'74.17 KB',0,1,'451 x 320 pixels','2022-10-17 06:05:14','2022-10-17 06:05:14'),
        (322,'image (8).png','image-81665990484.png',NULL,'102.26 KB',0,1,'2980 x 2548 pixels','2022-10-17 07:08:05','2022-10-17 07:08:05'),
        (323,'image (10).png','image-101666250163.png',NULL,'25.14 KB',0,1,'1278 x 512 pixels','2022-10-20 07:16:03','2022-10-20 07:16:03'),
        (324,'image (11).png','image-111666508652.png',NULL,'18.42 KB',0,1,'1178 x 400 pixels','2022-10-23 07:04:12','2022-10-23 07:04:12'),
        (325,'274277753_4842181969232427_5437853753661604973_n.jpg','274277753-4842181969232427-5437853753661604973-n1666509192.jpg',NULL,'395.29 KB',0,1,'1080 x 721 pixels','2022-10-23 07:13:12','2022-10-23 07:13:12'),
        (326,'292372067_5210078202442800_4831956654107540226_n.jpg','292372067-5210078202442800-4831956654107540226-n1666509192.jpg',NULL,'351.54 KB',0,1,'2048 x 1536 pixels','2022-10-23 07:13:12','2022-10-23 07:13:12'),
        (327,'br1.png','br11667215729.png',NULL,'2.84 KB',0,1,'175 x 46 pixels','2022-10-31 11:28:49','2022-10-31 11:28:49'),
        (328,'br2.png','br21667215729.png',NULL,'2.01 KB',0,1,'209 x 34 pixels','2022-10-31 11:28:49','2022-10-31 11:28:49'),
        (329,'br3.png','br31667215729.png',NULL,'3.11 KB',0,1,'224 x 55 pixels','2022-10-31 11:28:49','2022-10-31 11:28:49'),
        (330,'br4.png','br41667215729.png',NULL,'3 KB',0,1,'200 x 47 pixels','2022-10-31 11:28:49','2022-10-31 11:28:49'),
        (331,'br5.png','br51667215730.png',NULL,'3.18 KB',0,1,'196 x 56 pixels','2022-10-31 11:28:50','2022-10-31 11:28:50'),
        (337,'cl1.png','cl11668253973.png',NULL,'307.22 KB',0,1,'611 x 677 pixels','2022-11-12 11:52:53','2022-11-12 11:52:53'),
        (338,'cl2.png','cl21668253983.png',NULL,'439.16 KB',0,1,'611 x 677 pixels','2022-11-12 11:53:03','2022-11-12 11:53:03'),
        (339,'deal10.png','deal101668254225.png',NULL,'122.61 KB',0,1,'506 x 390 pixels','2022-11-12 11:57:05','2022-11-12 11:57:05'),
        (340,'author2.jpg','author21668255526.jpg',NULL,'8.12 KB',0,1,'65 x 64 pixels','2022-11-12 12:18:46','2022-11-12 12:18:46'),
        (341,'author1.jpg','author11668255526.jpg',NULL,'7 KB',0,1,'65 x 64 pixels','2022-11-12 12:18:46','2022-11-12 12:18:46'),
        (342,'author3.jpg','author31668255526.jpg',NULL,'7.1 KB',0,1,'65 x 64 pixels','2022-11-12 12:18:46','2022-11-12 12:18:46'),
        (343,'theme1_fd1.jpg','theme1-fd11668255526.jpg',NULL,'8.13 KB',0,1,'80 x 80 pixels','2022-11-12 12:18:46','2022-11-12 12:18:46'),
        (344,'theme1_fd2.jpg','theme1-fd21668255526.jpg',NULL,'9.36 KB',0,1,'80 x 80 pixels','2022-11-12 12:18:46','2022-11-12 12:18:46'),
        (348,'about_01_theme-min.jpg','about-01-theme-min1668533426.jpg',NULL,'99.46 KB',0,1,'800 x 800 pixels','2022-11-15 17:30:26','2022-11-15 17:30:26'),
        (349,'team1.jpg','team11668539086.jpg',NULL,'129.98 KB',0,1,'365 x 450 pixels','2022-11-15 19:04:46','2022-11-15 19:04:46'),
        (350,'Frame 34473-min.jpg','frame-34473-min1668590513.jpg',NULL,'42.59 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:53','2022-11-16 09:21:53'),
        (352,'Frame 34475-min.jpg','frame-34475-min1668590514.jpg',NULL,'73.8 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:55','2022-11-16 09:21:55'),
        (353,'Frame 34476-min.jpg','frame-34476-min1668590514.jpg',NULL,'34.18 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:55','2022-11-16 09:21:55'),
        (354,'Frame 34477-min.jpg','frame-34477-min1668590516.jpg',NULL,'54.34 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:56','2022-11-16 09:21:56'),
        (355,'Frame 34478-min.jpg','frame-34478-min1668590516.jpg',NULL,'40.69 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:56','2022-11-16 09:21:56'),
        (356,'Frame 34479-min.jpg','frame-34479-min1668590517.jpg',NULL,'28.16 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:57','2022-11-16 09:21:57'),
        (357,'Frame 34480-min.jpg','frame-34480-min1668590517.jpg',NULL,'55.91 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:58','2022-11-16 09:21:58'),
        (358,'Frame 34481-min.jpg','frame-34481-min1668590518.jpg',NULL,'33.92 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:59','2022-11-16 09:21:59'),
        (359,'Frame 34482-min.jpg','frame-34482-min1668590518.jpg',NULL,'45.16 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:21:59','2022-11-16 09:21:59'),
        (360,'Frame 34483-min.jpg','frame-34483-min1668590519.jpg',NULL,'22.13 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:00','2022-11-16 09:22:00'),
        (361,'Frame 34484-min.jpg','frame-34484-min1668590520.jpg',NULL,'44.47 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:00','2022-11-16 09:22:00'),
        (362,'Frame 34485-min.jpg','frame-34485-min1668590521.jpg',NULL,'45.83 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:01','2022-11-16 09:22:01'),
        (363,'Frame 34486-min.jpg','frame-34486-min1668590521.jpg',NULL,'59.14 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:02','2022-11-16 09:22:02'),
        (364,'Frame 34487-min.jpg','frame-34487-min1668590522.jpg',NULL,'40.95 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:03','2022-11-16 09:22:03'),
        (365,'Frame 34488-min.jpg','frame-34488-min1668590523.jpg',NULL,'43.39 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:03','2022-11-16 09:22:03'),
        (366,'Frame 34489-min.jpg','frame-34489-min1668590523.jpg',NULL,'40.4 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:04','2022-11-16 09:22:04'),
        (367,'Frame 34490-min.jpg','frame-34490-min1668590524.jpg',NULL,'39.48 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:04','2022-11-16 09:22:04'),
        (368,'Frame 34491-min.jpg','frame-34491-min1668590525.jpg',NULL,'114.92 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:05','2022-11-16 09:22:05'),
        (369,'Frame 34492-min.jpg','frame-34492-min1668590525.jpg',NULL,'15.49 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:06','2022-11-16 09:22:06'),
        (370,'Frame 34493-min.jpg','frame-34493-min1668590526.jpg',NULL,'52.31 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:22:06','2022-11-16 09:22:06'),
        (371,'Frame 34495-min.jpg','frame-34495-min1668592559.jpg',NULL,'29.6 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:55:59','2022-11-16 09:55:59'),
        (372,'Frame 34494-min.jpg','frame-34494-min1668592559.jpg',NULL,'51.41 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:00','2022-11-16 09:56:00'),
        (373,'Frame 34496-min.jpg','frame-34496-min1668592561.jpg',NULL,'55.22 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:01','2022-11-16 09:56:01'),
        (374,'Frame 34497-min.jpg','frame-34497-min1668592561.jpg',NULL,'35.42 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:01','2022-11-16 09:56:01'),
        (375,'Frame 34498-min.jpg','frame-34498-min1668592562.jpg',NULL,'36.36 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:03','2022-11-16 09:56:03'),
        (376,'Frame 34499-min.jpg','frame-34499-min1668592562.jpg',NULL,'62.55 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:03','2022-11-16 09:56:03'),
        (377,'Frame 34500-min.jpg','frame-34500-min1668592563.jpg',NULL,'26.54 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:04','2022-11-16 09:56:04'),
        (378,'Frame 34501-min.jpg','frame-34501-min1668592564.jpg',NULL,'35.26 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:04','2022-11-16 09:56:04'),
        (379,'Frame 34502-min.jpg','frame-34502-min1668592565.jpg',NULL,'71.03 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:05','2022-11-16 09:56:05'),
        (380,'Frame 34503-min.jpg','frame-34503-min1668592565.jpg',NULL,'65.65 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:05','2022-11-16 09:56:05'),
        (381,'Frame 34504-min.jpg','frame-34504-min1668592566.jpg',NULL,'30.43 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:06','2022-11-16 09:56:06'),
        (382,'Frame 34505-min.jpg','frame-34505-min1668592566.jpg',NULL,'41.38 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:07','2022-11-16 09:56:07'),
        (383,'Frame 34506-min.jpg','frame-34506-min1668592567.jpg',NULL,'39.8 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:08','2022-11-16 09:56:08'),
        (384,'Frame 34507-min.jpg','frame-34507-min1668592567.jpg',NULL,'63.06 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:08','2022-11-16 09:56:08'),
        (385,'Frame 34508-min.jpg','frame-34508-min1668592568.jpg',NULL,'24.18 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:08','2022-11-16 09:56:08'),
        (386,'Frame 34509-min.jpg','frame-34509-min1668592569.jpg',NULL,'37.52 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:09','2022-11-16 09:56:09'),
        (387,'Frame 34510-min.jpg','frame-34510-min1668592569.jpg',NULL,'37.9 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:10','2022-11-16 09:56:10'),
        (388,'Frame 34511-min.jpg','frame-34511-min1668592570.jpg',NULL,'59.82 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:10','2022-11-16 09:56:10'),
        (389,'Frame 34512-min.jpg','frame-34512-min1668592570.jpg',NULL,'39.41 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:11','2022-11-16 09:56:11'),
        (390,'Frame 34513-min.jpg','frame-34513-min1668592571.jpg',NULL,'44.3 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:11','2022-11-16 09:56:11'),
        (391,'Frame 34514-min.jpg','frame-34514-min1668592571.jpg',NULL,'46.25 KB',0,1,'1080 x 1080 pixels','2022-11-16 09:56:12','2022-11-16 09:56:12'),
        (392,'Frame 34474.jpg','frame-344741669031055.jpg',NULL,'120.73 KB',0,1,'1080 x 1080 pixels','2022-11-21 17:44:15','2022-11-21 17:44:15'),
        (393,'Frame 34473.jpg','frame-344731669032223.jpg',NULL,'219.15 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:03:44','2022-11-21 18:03:44'),
        (394,'Frame 34500.jpg','frame-345001669032465.jpg',NULL,'142.18 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:07:45','2022-11-21 18:07:45'),
        (395,'Frame 34500.jpg','frame-345001669033655.jpg',NULL,'142.18 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:27:35','2022-11-21 18:27:35'),
        (396,'Frame 34482.jpg','frame-344821669033900.jpg',NULL,'222.84 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:31:40','2022-11-21 18:31:40'),
        (397,'Frame 34523.jpg','frame-345231669033926.jpg',NULL,'292.35 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:32:06','2022-11-21 18:32:06'),
        (398,'Frame 34514.jpg','frame-345141669033926.jpg',NULL,'306.63 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:32:06','2022-11-21 18:32:06'),
        (399,'Frame 34501.jpg','frame-345011669034198.jpg',NULL,'162.51 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:36:38','2022-11-21 18:36:38'),
        (400,'Frame 34517 - Copy.jpg','frame-34517-copy1669034207.jpg',NULL,'205.47 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:36:48','2022-11-21 18:36:48'),
        (401,'Frame 34507 - Copy.jpg','frame-34507-copy1669034208.jpg',NULL,'378.76 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:36:48','2022-11-21 18:36:48'),
        (402,'Frame 34510 - Copy.jpg','frame-34510-copy1669034209.jpg',NULL,'174.1 KB',0,1,'1080 x 1080 pixels','2022-11-21 18:36:49','2022-11-21 18:36:49'),
        (403,'Frame 34507.jpg','frame-345071669035674.jpg',NULL,'378.76 KB',0,1,'1080 x 1080 pixels','2022-11-21 19:01:14','2022-11-21 19:01:14'),
        (404,'Frame 34492.jpg','frame-344921669036178.jpg',NULL,'119.79 KB',0,1,'1080 x 1080 pixels','2022-11-21 19:09:38','2022-11-21 19:09:38'),
        (405,'Frame 34525.jpg','frame-345251669037215.jpg',NULL,'198.62 KB',0,1,'1080 x 1080 pixels','2022-11-21 19:26:55','2022-11-21 19:26:55'),
        (406,'Frame 34518.jpg','frame-345181669116463.jpg',NULL,'147.75 KB',0,1,'1080 x 1080 pixels','2022-11-22 17:27:44','2022-11-22 17:27:44'),
        (407,'Frame 34485.jpg','frame-344851669179639.jpg',NULL,'342.21 KB',0,1,'1080 x 1080 pixels','2022-11-23 11:00:39','2022-11-23 11:00:39'),
        (408,'Frame 34544.jpg','frame-345441669181210.jpg',NULL,'255.75 KB',0,1,'1080 x 1080 pixels','2022-11-23 11:26:50','2022-11-23 11:26:50'),
        (409,'Frame 34528.jpg','frame-345281669181751.jpg',NULL,'177.11 KB',0,1,'1080 x 1080 pixels','2022-11-23 11:35:51','2022-11-23 11:35:51'),
        (410,'Frame 34526.jpg','frame-345261669181973.jpg',NULL,'266.14 KB',0,1,'1080 x 1080 pixels','2022-11-23 11:39:34','2022-11-23 11:39:34'),
        (411,'Frame 34528.jpg','frame-345281669182634.jpg',NULL,'177.11 KB',0,1,'1080 x 1080 pixels','2022-11-23 11:50:35','2022-11-23 11:50:35'),
        (412,'Frame 34516.jpg','frame-345161669182654.jpg',NULL,'238.85 KB',0,1,'1080 x 1080 pixels','2022-11-23 11:50:55','2022-11-23 11:50:55'),
        (413,'Frame 34542.jpg','frame-345421669183244.jpg',NULL,'265.21 KB',0,1,'1080 x 1080 pixels','2022-11-23 12:00:44','2022-11-23 12:00:44'),
        (414,'Frame 34484.jpg','frame-344841669184791.jpg',NULL,'241.28 KB',0,1,'1080 x 1080 pixels','2022-11-23 12:26:32','2022-11-23 12:26:32'),
        (415,'Frame 34473.jpg','frame-344731669202600.jpg',NULL,'219.15 KB',0,1,'1080 x 1080 pixels','2022-11-23 17:23:20','2022-11-23 17:23:20'),
        (416,'Frame 34473.jpg','frame-344731669203077.jpg',NULL,'219.15 KB',0,1,'1080 x 1080 pixels','2022-11-23 17:31:17','2022-11-23 17:31:17'),
        (417,'Frame 34547.jpg','frame-345471669205100.jpg',NULL,'11.33 KB',0,1,'270 x 270 pixels','2022-11-23 18:05:00','2022-11-23 18:05:00'),
        (418,'Frame 34546.jpg','frame-345461669205100.jpg',NULL,'9.63 KB',0,1,'270 x 270 pixels','2022-11-23 18:05:00','2022-11-23 18:05:00'),
        (419,'Frame 34548.jpg','frame-345481669205101.jpg',NULL,'11.33 KB',0,1,'270 x 270 pixels','2022-11-23 18:05:02','2022-11-23 18:05:02'),
        (420,'Frame 34549.jpg','frame-345491669205102.jpg',NULL,'10.72 KB',0,1,'270 x 270 pixels','2022-11-23 18:05:02','2022-11-23 18:05:02'),
        (421,'Frame 34570.png','frame-345701669210618.png',NULL,'47.29 KB',0,1,'1080 x 1080 pixels','2022-11-23 19:36:58','2022-11-23 19:36:58'),
        (422,'Frame 34571.png','frame-345711669210618.png',NULL,'201.88 KB',0,1,'1080 x 1080 pixels','2022-11-23 19:36:59','2022-11-23 19:36:59'),
        (423,'Frame 34572.png','frame-345721669210620.png',NULL,'245.59 KB',0,1,'1080 x 1080 pixels','2022-11-23 19:37:00','2022-11-23 19:37:00'),
        (424,'Frame 34573.png','frame-345731669210620.png',NULL,'50.5 KB',0,1,'1080 x 1080 pixels','2022-11-23 19:37:01','2022-11-23 19:37:01'),
        (425,'Frame 34574.png','frame-345741669210622.png',NULL,'173.36 KB',0,1,'1080 x 1080 pixels','2022-11-23 19:37:02','2022-11-23 19:37:02'),
        (426,'Frame 34555.png','frame-345551669212294.png',NULL,'459.23 KB',0,1,'1080 x 1080 pixels','2022-11-23 20:04:55','2022-11-23 20:04:55'),
        (427,'Frame 34556.png','frame-345561669212295.png',NULL,'1.24 MB',0,1,'1080 x 1080 pixels','2022-11-23 20:04:56','2022-11-23 20:04:56'),
        (428,'Frame 34557.png','frame-345571669212296.png',NULL,'349.75 KB',0,1,'1080 x 1080 pixels','2022-11-23 20:04:57','2022-11-23 20:04:57'),
        (429,'Frame 34558.png','frame-345581669212299.png',NULL,'1.16 MB',0,1,'1080 x 1080 pixels','2022-11-23 20:05:00','2022-11-23 20:05:00'),
        (430,'Frame 34559.png','frame-345591669212301.png',NULL,'1.23 MB',0,1,'1080 x 1080 pixels','2022-11-23 20:05:01','2022-11-23 20:05:01'),
        (431,'Frame 34566.png','frame-345661669214166.png',NULL,'326.11 KB',0,1,'1080 x 1080 pixels','2022-11-23 20:36:06','2022-11-23 20:36:06'),
        (432,'Frame 34565.png','frame-345651669214166.png',NULL,'675.35 KB',0,1,'1080 x 1080 pixels','2022-11-23 20:36:07','2022-11-23 20:36:07'),
        (433,'Frame 34567.png','frame-345671669214169.png',NULL,'639.91 KB',0,1,'1080 x 1080 pixels','2022-11-23 20:36:09','2022-11-23 20:36:09'),
        (434,'Frame 34568.png','frame-345681669214170.png',NULL,'617.23 KB',0,1,'1080 x 1080 pixels','2022-11-23 20:36:10','2022-11-23 20:36:10'),
        (435,'Frame 34575.png','frame-345751669216288.png',NULL,'438.12 KB',0,1,'1080 x 1080 pixels','2022-11-23 21:11:29','2022-11-23 21:11:29'),
        (436,'Frame 34576.png','frame-345761669216288.png',NULL,'649.26 KB',0,1,'1080 x 1080 pixels','2022-11-23 21:11:29','2022-11-23 21:11:29'),
        (437,'Frame 34577.png','frame-345771669216290.png',NULL,'403.84 KB',0,1,'1080 x 1080 pixels','2022-11-23 21:11:31','2022-11-23 21:11:31'),
        (438,'Frame 34578.png','frame-345781669216290.png',NULL,'353.08 KB',0,1,'1080 x 1080 pixels','2022-11-23 21:11:31','2022-11-23 21:11:31'),
        (439,'Frame 34579.png','frame-345791669216292.png',NULL,'113.38 KB',0,1,'1080 x 1080 pixels','2022-11-23 21:11:33','2022-11-23 21:11:33'),
        (440,'Frame 34577.png','frame-345771669216629.png',NULL,'403.84 KB',0,1,'1080 x 1080 pixels','2022-11-23 21:17:09','2022-11-23 21:17:09'),
        (441,'logo1658814161.png','logo16588141611672656199.png',NULL,'6.64 KB',0,1,'251 x 61 pixels','2023-01-02 16:43:19','2023-01-02 16:43:19'),
        (442,'square-logo1658814802.jpg','square-logo16588148021672656220.jpg',NULL,'28.46 KB',0,1,'1280 x 720 pixels','2023-01-02 16:43:40','2023-01-02 16:43:40'),
        (443,'untitled-design-81658815830.jpg','untitled-design-816588158301672656233.jpg',NULL,'7.18 KB',0,1,'440 x 260 pixels','2023-01-02 16:43:53','2023-01-02 16:43:53'),
        (444,'83-836574-paytabs-in-the-news-paytabs1658816083.png','83-836574-paytabs-in-the-news-paytabs16588160831672656276.png',NULL,'543.02 KB',0,1,'5253 x 1605 pixels','2023-01-02 16:44:37','2023-01-02 16:44:37'),
        (445,'logo-facebook-dimension-912ae2521fe6b786a8c78a5cd1a7dfb31434c628a7d03f4377cbeb4707d6e3051658816200.png','logo-facebook-dimension-912ae2521fe6b786a8c78a5cd1a7dfb31434c628a7d03f4377cbeb4707d6e30516588162001672656309.png',NULL,'15.13 KB',0,1,'1200 x 630 pixels','2023-01-02 16:45:09','2023-01-02 16:45:09'),
        (446,'seotyp-20221670242046.png','seotyp-202216702420461672656321.png',NULL,'4.39 KB',0,1,'416 x 279 pixels','2023-01-02 16:45:21','2023-01-02 16:45:21'),
        (447,'0-raingeih9ih8rpiv1670242309.png','0-raingeih9ih8rpiv16702423091672656332.png',NULL,'20.98 KB',0,1,'1200 x 630 pixels','2023-01-02 16:45:32','2023-01-02 16:45:32'),
        (448,'png.png','png1672745233.png',NULL,'13.73 KB',0,1,'723 x 74 pixels','2023-01-03 17:27:13','2023-01-03 17:27:13'),
        (449,'theme21668949363.png','theme216689493631672754116.png',NULL,'410.2 KB',0,1,'755 x 557 pixels','2023-01-03 19:55:16','2023-01-03 19:55:16'),
        (451,'cl3.png','cl31672754349.png',NULL,'66.64 KB',0,1,'449 x 402 pixels','2023-01-03 19:59:09','2023-01-03 19:59:09'),
        (452,'cl4.png','cl41672754360.png',NULL,'96.92 KB',0,1,'405 x 402 pixels','2023-01-03 19:59:20','2023-01-03 19:59:20'),
        (453,'arrival1.png','arrival11672754526.png',NULL,'261.87 KB',0,1,'611 x 385 pixels','2023-01-03 20:02:06','2023-01-03 20:02:06'),
        (454,'03_logo_themes.png','03-logo-themes1677324023.png',NULL,'3.02 KB',0,1,'181 x 32 pixels','2023-02-25 17:20:23','2023-02-25 17:20:23'),
        (455,'03_themes_favicon.png','03-themes-favicon1677324189.png',NULL,'486 ',0,1,'37 x 32 pixels','2023-02-25 17:23:09','2023-02-25 17:23:09'),
        (456,'theme3.png','theme31677389322.png',NULL,'296.02 KB',0,1,'862 x 766 pixels','2023-02-26 11:28:42','2023-02-26 11:28:42'),
        (457,'category2.png','category21677483542.png',NULL,'7.57 KB',0,1,'120 x 120 pixels','2023-02-27 13:39:02','2023-02-27 13:39:02'),
        (459,'category3.png','category31677483542.png',NULL,'12.2 KB',0,1,'120 x 120 pixels','2023-02-27 13:39:02','2023-02-27 13:39:02'),
        (460,'category4.png','category41677483542.png',NULL,'10.64 KB',0,1,'120 x 120 pixels','2023-02-27 13:39:02','2023-02-27 13:39:02'),
        (461,'category5.png','category51677483542.png',NULL,'21.84 KB',0,1,'120 x 120 pixels','2023-02-27 13:39:02','2023-02-27 13:39:02'),
        (462,'category1.png','category11677486590.png',NULL,'11.52 KB',0,1,'120 x 120 pixels','2023-02-27 14:29:50','2023-02-27 14:29:50')");
    }
}

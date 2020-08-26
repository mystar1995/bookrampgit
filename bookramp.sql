-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 20-06-27 15:39
-- 서버 버전: 10.4.11-MariaDB
-- PHP 버전: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `bookramp`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `author_rating`
--

CREATE TABLE `author_rating` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `review` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `rating` int(11) NOT NULL,
  `reader` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `available_keywords`
--

CREATE TABLE `available_keywords` (
  `id` int(11) NOT NULL,
  `keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `available_keywords`
--

INSERT INTO `available_keywords` (`id`, `keywords`) VALUES
(1, 'love'),
(2, 'aaaa'),
(3, 'aaa'),
(4, 'sports'),
(5, 'museum'),
(6, 'aaab'),
(7, 'aaac'),
(8, 'jhonsmith'),
(9, 'jhonsmits'),
(10, 'aaajjj'),
(11, 'history and art'),
(12, 'destiny'),
(13, 'history and artq'),
(14, 'adventes'),
(15, 'a');

-- --------------------------------------------------------

--
-- 테이블 구조 `bookmark`
--

CREATE TABLE `bookmark` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `reader_id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `bookmark`
--

INSERT INTO `bookmark` (`id`, `content_id`, `reader_id`, `page`, `created_at`) VALUES
(19, 2, 23, 1, '2020-06-17 15:52:28'),
(20, 9, 23, 5, '2020-06-17 15:53:00'),
(21, 9, 23, 9, '2020-06-17 15:53:12'),
(22, 9, 23, 16, '2020-06-18 05:22:59'),
(23, 9, 23, 98, '2020-06-18 05:26:23'),
(24, 9, 23, 98, '2020-06-18 05:26:24'),
(27, 2, 18, 1, '2020-06-21 08:00:06'),
(28, 28, 23, 1, '2020-06-25 09:35:07'),
(29, 2, 27, 1, '2020-06-25 22:04:24'),
(30, 9, 27, 5, '2020-06-27 14:03:45'),
(31, 9, 27, 7, '2020-06-27 21:17:13'),
(32, 22, 27, 1, '2020-06-27 21:17:33');

-- --------------------------------------------------------

--
-- 테이블 구조 `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cover_url` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `category`
--

INSERT INTO `category` (`id`, `cover_url`, `category`, `description`) VALUES
(7, './uploads/category/category_1593093964.png', 'Comic', 'These books are based on a sequence of hand-drawn pictures. The story is usually told visually with very few words and those words are mostly placed either in panels on top or bottom of pictures or as speech bubbles.'),
(8, './uploads/category/category_1593093839.jpeg', 'Horror', 'Horror is a genre that is intended to or has the ability to create the feeling of fear, repulsion, fright or terror in the readers. In other words, it creates a frightening and horror atmosphere.'),
(9, './uploads/category/category_1593094048.jpg', 'Romance', 'The primary focus of romance fiction is on the relationship and romantic love between two people. These books have an emotionally satisfying and optimistic ending.'),
(10, './uploads/category/category_1593094300.jpg', 'Science', 'Science Fiction typically deals with imaginative and futuristic concepts such as advanced science and technology, time travel, extraterrestrial life, etc. The stories are often set in the future or on other planets.'),
(11, './uploads/category/category_1593094560.jpg', 'Action and Adventure', 'The stories under this genre usually show an event or a series of events that happen outside the course of the protagonist’s ordinary life. The plot is mostly accompanied by danger and physical action. '),
(12, './uploads/category/category_1593095930.jpg', 'Drama', 'Dramas are stories composed in verse or prose, usually for theatrical performance, where conflicts and emotions are expressed through dialogue and actions.'),
(13, './uploads/category/category_1593095052.jpg', 'Historical Fiction', 'Historical fiction is a genre of book that includes writings that reconstruct the past. ');

-- --------------------------------------------------------

--
-- 테이블 구조 `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `cover_image` varchar(200) NOT NULL,
  `content_file` varchar(200) NOT NULL,
  `age_group` varchar(30) NOT NULL,
  `language` varchar(30) NOT NULL,
  `category` int(11) NOT NULL,
  `story` text NOT NULL,
  `author` int(11) NOT NULL,
  `recommended` tinyint(1) NOT NULL,
  `point` int(11) NOT NULL,
  `book_content` text NOT NULL,
  `status` enum('PUBLISHED','UNDERREVIEW','REJECTED','DRAFT') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `content`
--

INSERT INTO `content` (`id`, `title`, `description`, `cover_image`, `content_file`, `age_group`, `language`, `category`, `story`, `author`, `recommended`, `point`, `book_content`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Night Shift', 'Night Shift', './uploads/books/user_1593096936.jpg', './uploads/docs/user_1589600664.pdf', '12', 'en', 11, 'Night Shift Book', 18, 1, 12, '', 'PUBLISHED', '2020-05-20 06:38:18', '2020-06-26 08:23:35'),
(6, 'React Native Programming', 'React Native Programming', './uploads/books/user_1593097181.png', '', '5', 'en', 10, 'This is for React Native Programming', 18, 1, 9, '', 'PUBLISHED', '2020-05-23 23:58:02', '2020-06-26 08:23:35'),
(8, 'title', 'description', '/uploads/books/user_1590613563.png', '', '15', 'en', 7, 'this is story for others', 20, 1, 2, '', 'UNDERREVIEW', '2020-05-28 05:06:03', '2020-06-26 08:23:35'),
(9, 'Nora Barrett', 'description', './uploads/books/user_1593096780.jpg', './uploads/docs/user_1590248768.pdf', '12', 'en', 12, 'story', 20, 1, 9, '', 'PUBLISHED', '2020-05-28 08:09:48', '2020-06-26 08:23:35'),
(10, 'Test Book Test 123', 'book description', 'uploads/books/user_1592012407.png', '', '18', 'en', 7, 'this is story', 14, 1, 2, '', 'UNDERREVIEW', '2020-06-13 07:03:49', '2020-06-26 08:23:35'),
(16, 'title1', 'asdasd', '', '', '30', 'en', 9, 'asdasdasd', 23, 0, 0, '', 'UNDERREVIEW', '2020-06-15 17:13:44', '2020-06-26 08:23:35'),
(17, 'asdasdasd', 'asdasd', 'uploads/books/user_1592209028.png', '', '18', 'en', 9, 'asdasdasd', 23, 0, 0, '', 'UNDERREVIEW', '2020-06-15 17:17:08', '2020-06-26 08:23:35'),
(22, 'The Crying Game From The Trees', 'The Crying Game From The Trees', './uploads/books/user_1593098394.jpg', '', '18', 'en', 8, 'The Crying Game From The Trees', 38, 0, 4, '<p>hi</p><p><br></p>', '', '2020-06-18 09:30:37', '2020-06-26 08:23:35'),
(23, 'aasdasd', 'asdasd', 'uploads/books/user_1592499684.png', '', '18', 'en', 9, 'sdfsdfsdfsdf', 18, 0, 0, '', 'UNDERREVIEW', '2020-06-19 02:01:24', '2020-06-26 08:23:35'),
(24, 'asdasdasda', 'asdasd', 'uploads/books/user_1592553699.png', '', '18', 'en', 9, 'asdasdasdasd', 18, 0, 0, '<h1>This is title for text</h1><p>I want to <strong>add</strong> this test text</p><p><br></p><h1>提示</h1><h1><br></h1>', 'UNDERREVIEW', '2020-06-19 17:01:39', '2020-06-26 08:23:35'),
(25, 'adaa', 'adsaa', 'uploads/books/user_1592579407.jpg', 'uploads/docs/user_1592579407.jpg', '18', 'en', 9, 'bababababa ', 39, 0, 0, '', 'DRAFT', '2020-06-20 00:10:07', '2020-06-26 08:23:35'),
(28, 'A Beautiful Crime', 'A Beautiful Crime Novel', './uploads/books/user_1593096868.jpg', '', '18', 'en', 9, 'A Beautiful Crime Novel', 18, 0, 3, '<h1>Test Example</h1><p>this is example of <em><strong>drafts &nbsp;This is very popular function</strong></em></p><ul>  <li><em><strong>I know this function well</strong></em></li>  <li><br></li></ul><p><br></p>', 'PUBLISHED', '2020-06-25 08:44:21', '2020-06-26 08:23:35'),
(29, 'testing', 'testing', 'uploads/books/user_1593089756.jpg', '', '30', 'en', 7, 'testing details\n', 38, 0, 0, '<ul>  <li>boo hhftuih</li>  <li>asdsadasd</li></ul><ol>  <li>asdasdasd</li></ol><p><br></p><p><br></p><p><br></p>', 'UNDERREVIEW', '2020-06-25 21:55:56', '2020-06-26 08:23:35'),
(30, 'Testing', 'testing', 'uploads/books/user_1593193868.png', '', '15', 'en', 8, 'testing\n', 38, 0, 0, '<p>gjklll</p><p>gjklll</p><p>buddy</p><p>jklojf77f</p><p><br></p>', 'UNDERREVIEW', '2020-06-27 02:51:08', '2020-06-27 02:51:08'),
(31, 'Testing', 'testing', 'uploads/books/user_1593193870.png', '', '15', 'en', 8, 'testing\n', 38, 0, 0, '<p>fhjjkooigch</p><p>hjk</p>', 'DRAFT', '2020-06-27 02:51:10', '2020-06-27 02:51:10');

-- --------------------------------------------------------

--
-- 테이블 구조 `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonecode` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonemask` char(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`, `phonecode`, `phonemask`, `active`) VALUES
(1, 'AF', 'Afghanistan', '93', '0000000000', 1),
(2, 'AL', 'Albania', '355', '0000000000', 1),
(3, 'DZ', 'Algeria', '213', '0000000000', 1),
(4, 'AS', 'American Samoa', '1684', '0000000000', 1),
(5, 'AD', 'Andorra', '376', '0000000000', 1),
(6, 'AO', 'Angola', '244', '0000000000', 1),
(7, 'AI', 'Anguilla', '1264', '0000000000', 1),
(8, 'AQ', 'Antarctica', '0', '0000000000', 1),
(9, 'AG', 'Antigua And Barbuda', '1268', '0000000000', 1),
(10, 'AR', 'Argentina', '54', '0000000000', 1),
(11, 'AM', 'Armenia', '374', '0000000000', 1),
(12, 'AW', 'Aruba', '297', '0000000000', 1),
(13, 'AU', 'Australia', '61', '0000000000', 1),
(14, 'AT', 'Austria', '43', '0000000000', 1),
(15, 'AZ', 'Azerbaijan', '994', '0000000000', 1),
(16, 'BS', 'Bahamas The', '1242', '0000000000', 1),
(17, 'BH', 'Bahrain', '973', '0000000000', 1),
(18, 'BD', 'Bangladesh', '880', '0000000000', 1),
(19, 'BB', 'Barbados', '1246', '0000000000', 1),
(20, 'BY', 'Belarus', '375', '0000000000', 1),
(21, 'BE', 'Belgium', '32', '0000000000', 1),
(22, 'BZ', 'Belize', '501', '0000000000', 1),
(23, 'BJ', 'Benin', '229', '0000000000', 1),
(24, 'BM', 'Bermuda', '1441', '0000000000', 1),
(25, 'BT', 'Bhutan', '975', '0000000000', 1),
(26, 'BO', 'Bolivia', '591', '0000000000', 1),
(27, 'BA', 'Bosnia and Herzegovina', '387', '0000000000', 1),
(28, 'BW', 'Botswana', '267', '0000000000', 1),
(29, 'BV', 'Bouvet Island', '0', '0000000000', 1),
(30, 'BR', 'Brazil', '55', '0000000000', 1),
(31, 'IO', 'British Indian Ocean Territory', '246', '0000000000', 1),
(32, 'BN', 'Brunei', '673', '0000000000', 1),
(33, 'BG', 'Bulgaria', '359', '0000000000', 1),
(34, 'BF', 'Burkina Faso', '226', '0000000000', 1),
(35, 'BI', 'Burundi', '257', '0000000000', 1),
(36, 'KH', 'Cambodia', '855', '0000000000', 1),
(37, 'CM', 'Cameroon', '237', '0000000000', 1),
(38, 'CA', 'Canada', '1', '0000000000', 1),
(39, 'CV', 'Cape Verde', '238', '0000000000', 1),
(40, 'KY', 'Cayman Islands', '1345', '0000000000', 1),
(41, 'CF', 'Central African Republic', '236', '0000000000', 1),
(42, 'TD', 'Chad', '235', '0000000000', 1),
(43, 'CL', 'Chile', '56', '0000000000', 1),
(44, 'CN', 'China', '86', '0000000000', 1),
(45, 'CX', 'Christmas Island', '61', '0000000000', 1),
(46, 'CC', 'Cocos (Keeling) Islands', '672', '0000000000', 1),
(47, 'CO', 'Colombia', '57', '0000000000', 1),
(48, 'KM', 'Comoros', '269', '0000000000', 1),
(49, 'CG', 'Congo', '242', '0000000000', 1),
(50, 'CD', 'Congo The Democratic Republic Of The', '242', '0000000000', 1),
(51, 'CK', 'Cook Islands', '682', '0000000000', 1),
(52, 'CR', 'Costa Rica', '506', '0000000000', 1),
(53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', '225', '0000000000', 1),
(54, 'HR', 'Croatia (Hrvatska)', '385', '0000000000', 1),
(55, 'CU', 'Cuba', '53', '0000000000', 0),
(56, 'CY', 'Cyprus', '357', '0000000000', 1),
(57, 'CZ', 'Czech Republic', '420', '0000000000', 1),
(58, 'DK', 'Denmark', '45', '0000000000', 1),
(59, 'DJ', 'Djibouti', '253', '0000000000', 1),
(60, 'DM', 'Dominica', '1767', '0000000000', 1),
(61, 'DO', 'Dominican Republic', '1809', '0000000000', 1),
(62, 'TP', 'East Timor', '670', '0000000000', 1),
(63, 'EC', 'Ecuador', '593', '0000000000', 1),
(64, 'EG', 'Egypt', '20', '0000000000', 1),
(65, 'SV', 'El Salvador', '503', '0000000000', 1),
(66, 'GQ', 'Equatorial Guinea', '240', '0000000000', 1),
(67, 'ER', 'Eritrea', '291', '0000000000', 1),
(68, 'EE', 'Estonia', '372', '0000000000', 1),
(69, 'ET', 'Ethiopia', '251', '0000000000', 1),
(70, 'XA', 'External Territories of Australia', '61', '0000000000', 1),
(71, 'FK', 'Falkland Islands', '500', '0000000000', 1),
(72, 'FO', 'Faroe Islands', '298', '0000000000', 1),
(73, 'FJ', 'Fiji Islands', '679', '0000000000', 1),
(74, 'FI', 'Finland', '358', '0000000000', 1),
(75, 'FR', 'France', '33', '0000000000', 1),
(76, 'GF', 'French Guiana', '594', '0000000000', 1),
(77, 'PF', 'French Polynesia', '689', '0000000000', 1),
(78, 'TF', 'French Southern Territories', '0', '0000000000', 1),
(79, 'GA', 'Gabon', '241', '0000000000', 1),
(80, 'GM', 'Gambia The', '220', '0000000000', 1),
(81, 'GE', 'Georgia', '995', '0000000000', 1),
(82, 'DE', 'Germany', '49', '0000000000', 1),
(83, 'GH', 'Ghana', '233', '0000000000', 1),
(84, 'GI', 'Gibraltar', '350', '0000000000', 1),
(85, 'GR', 'Greece', '30', '0000000000', 1),
(86, 'GL', 'Greenland', '299', '0000000000', 1),
(87, 'GD', 'Grenada', '1473', '0000000000', 1),
(88, 'GP', 'Guadeloupe', '590', '0000000000', 1),
(89, 'GU', 'Guam', '1671', '0000000000', 1),
(90, 'GT', 'Guatemala', '502', '0000000000', 1),
(91, 'XU', 'Guernsey and Alderney', '44', '0000000000', 1),
(92, 'GN', 'Guinea', '224', '0000000000', 1),
(93, 'GW', 'Guinea-Bissau', '245', '0000000000', 1),
(94, 'GY', 'Guyana', '592', '0000000000', 1),
(95, 'HT', 'Haiti', '509', '0000000000', 1),
(96, 'HM', 'Heard and McDonald Islands', '0', '0000000000', 1),
(97, 'HN', 'Honduras', '504', '0000000000', 1),
(98, 'HK', 'Hong Kong S.A.R.', '852', '0000000000', 1),
(99, 'HU', 'Hungary', '36', '0000000000', 1),
(100, 'IS', 'Iceland', '354', '0000000000', 1),
(101, 'IN', 'India', '91', '0000000000', 1),
(102, 'ID', 'Indonesia', '62', '0000000000', 1),
(103, 'IR', 'Iran', '98', '0000000000', 1),
(104, 'IQ', 'Iraq', '964', '0000000000', 1),
(105, 'IE', 'Ireland', '353', '0000000000', 1),
(106, 'IL', 'Israel', '972', '0000000000', 1),
(107, 'IT', 'Italy', '39', '0000000000', 1),
(108, 'JM', 'Jamaica', '1876', '0000000000', 1),
(109, 'JP', 'Japan', '81', '0000000000', 1),
(110, 'XJ', 'Jersey', '44', '0000000000', 1),
(111, 'JO', 'Jordan', '962', '0000000000', 1),
(112, 'KZ', 'Kazakhstan', '7', '0000000000', 1),
(113, 'KE', 'Kenya', '254', '0000000000', 1),
(114, 'KI', 'Kiribati', '686', '0000000000', 1),
(115, 'KP', 'Korea North', '850', '0000000000', 0),
(116, 'KR', 'Korea South', '82', '0000000000', 1),
(117, 'KW', 'Kuwait', '965', '0000000000', 1),
(118, 'KG', 'Kyrgyzstan', '996', '0000000000', 1),
(119, 'LA', 'Laos', '856', '0000000000', 1),
(120, 'LV', 'Latvia', '371', '0000000000', 1),
(121, 'LB', 'Lebanon', '961', '0000000000', 1),
(122, 'LS', 'Lesotho', '266', '0000000000', 1),
(123, 'LR', 'Liberia', '231', '0000000000', 1),
(124, 'LY', 'Libya', '218', '0000000000', 1),
(125, 'LI', 'Liechtenstein', '423', '0000000000', 1),
(126, 'LT', 'Lithuania', '370', '0000000000', 1),
(127, 'LU', 'Luxembourg', '352', '0000000000', 1),
(128, 'MO', 'Macau S.A.R.', '853', '0000000000', 1),
(129, 'MK', 'Macedonia', '389', '0000000000', 1),
(130, 'MG', 'Madagascar', '261', '0000000000', 1),
(131, 'MW', 'Malawi', '265', '0000000000', 1),
(132, 'MY', 'Malaysia', '60', '0000000000', 1),
(133, 'MV', 'Maldives', '960', '0000000000', 1),
(134, 'ML', 'Mali', '223', '0000000000', 1),
(135, 'MT', 'Malta', '356', '0000000000', 1),
(136, 'XM', 'Man (Isle of)', '44', '0000000000', 1),
(137, 'MH', 'Marshall Islands', '692', '0000000000', 1),
(138, 'MQ', 'Martinique', '596', '0000000000', 1),
(139, 'MR', 'Mauritania', '222', '0000000000', 1),
(140, 'MU', 'Mauritius', '230', '0000000000', 1),
(141, 'YT', 'Mayotte', '269', '0000000000', 1),
(142, 'MX', 'Mexico', '52', '0000000000', 1),
(143, 'FM', 'Micronesia', '691', '0000000000', 1),
(144, 'MD', 'Moldova', '373', '0000000000', 1),
(145, 'MC', 'Monaco', '377', '0000000000', 1),
(146, 'MN', 'Mongolia', '976', '0000000000', 1),
(147, 'MS', 'Montserrat', '1664', '0000000000', 1),
(148, 'MA', 'Morocco', '212', '0000000000', 1),
(149, 'MZ', 'Mozambique', '258', '0000000000', 1),
(150, 'MM', 'Myanmar', '95', '0000000000', 1),
(151, 'NA', 'Namibia', '264', '0000000000', 1),
(152, 'NR', 'Nauru', '674', '0000000000', 1),
(153, 'NP', 'Nepal', '977', '0000000000', 1),
(154, 'AN', 'Netherlands Antilles', '599', '0000000000', 1),
(155, 'NL', 'Netherlands The', '31', '0000000000', 1),
(156, 'NC', 'New Caledonia', '687', '0000000000', 1),
(157, 'NZ', 'New Zealand', '64', '0000000000', 1),
(158, 'NI', 'Nicaragua', '505', '0000000000', 1),
(159, 'NE', 'Niger', '227', '0000000000', 1),
(160, 'NG', 'Nigeria', '234', '0000000000', 1),
(161, 'NU', 'Niue', '683', '0000000000', 1),
(162, 'NF', 'Norfolk Island', '672', '0000000000', 1),
(163, 'MP', 'Northern Mariana Islands', '1670', '0000000000', 1),
(164, 'NO', 'Norway', '47', '0000000000', 1),
(165, 'OM', 'Oman', '968', '0000000000', 1),
(166, 'PK', 'Pakistan', '92', '0000000000', 1),
(167, 'PW', 'Palau', '680', '0000000000', 1),
(168, 'PS', 'Palestinian Territory Occupied', '970', '0000000000', 1),
(169, 'PA', 'Panama', '507', '0000000000', 1),
(170, 'PG', 'Papua new Guinea', '675', '0000000000', 1),
(171, 'PY', 'Paraguay', '595', '0000000000', 1),
(172, 'PE', 'Peru', '51', '0000000000', 1),
(173, 'PH', 'Philippines', '63', '0000000000', 1),
(174, 'PN', 'Pitcairn Island', '0', '0000000000', 1),
(175, 'PL', 'Poland', '48', '0000000000', 1),
(176, 'PT', 'Portugal', '351', '0000000000', 1),
(177, 'PR', 'Puerto Rico', '1787', '0000000000', 1),
(178, 'QA', 'Qatar', '974', '0000000000', 1),
(179, 'RE', 'Reunion', '262', '0000000000', 1),
(180, 'RO', 'Romania', '40', '0000000000', 1),
(181, 'RU', 'Russia', '70', '0000000000', 1),
(182, 'RW', 'Rwanda', '250', '0000000000', 1),
(183, 'SH', 'Saint Helena', '290', '0000000000', 1),
(184, 'KN', 'Saint Kitts And Nevis', '1869', '0000000000', 1),
(185, 'LC', 'Saint Lucia', '1758', '0000000000', 1),
(186, 'PM', 'Saint Pierre and Miquelon', '508', '0000000000', 1),
(187, 'VC', 'Saint Vincent And The Grenadines', '1784', '0000000000', 1),
(188, 'WS', 'Samoa', '684', '0000000000', 1),
(189, 'SM', 'San Marino', '378', '0000000000', 1),
(190, 'ST', 'Sao Tome and Principe', '239', '0000000000', 1),
(191, 'SA', 'Saudi Arabia', '966', '0000000000', 1),
(192, 'SN', 'Senegal', '221', '0000000000', 1),
(193, 'RS', 'Serbia', '381', '0000000000', 1),
(194, 'SC', 'Seychelles', '248', '0000000000', 1),
(195, 'SL', 'Sierra Leone', '232', '0000000000', 1),
(196, 'SG', 'Singapore', '65', '0000000000', 1),
(197, 'SK', 'Slovakia', '421', '0000000000', 1),
(198, 'SI', 'Slovenia', '386', '0000000000', 1),
(199, 'XG', 'Smaller Territories of the UK', '44', '0000000000', 1),
(200, 'SB', 'Solomon Islands', '677', '0000000000', 1),
(201, 'SO', 'Somalia', '252', '0000000000', 1),
(202, 'ZA', 'South Africa', '27', '0000000000', 1),
(203, 'GS', 'South Georgia', '0', '0000000000', 1),
(204, 'SS', 'South Sudan', '211', '0000000000', 1),
(205, 'ES', 'Spain', '34', '0000000000', 1),
(206, 'LK', 'Sri Lanka', '94', '0000000000', 1),
(207, 'SD', 'Sudan', '249', '0000000000', 1),
(208, 'SR', 'Suriname', '597', '0000000000', 1),
(209, 'SJ', 'Svalbard And Jan Mayen Islands', '47', '0000000000', 1),
(210, 'SZ', 'Swaziland', '268', '0000000000', 1),
(211, 'SE', 'Sweden', '46', '0000000000', 1),
(212, 'CH', 'Switzerland', '41', '0000000000', 1),
(213, 'SY', 'Syria', '963', '0000000000', 0),
(214, 'TW', 'Taiwan', '886', '0000000000', 1),
(215, 'TJ', 'Tajikistan', '992', '0000000000', 1),
(216, 'TZ', 'Tanzania', '255', '0000000000', 1),
(217, 'TH', 'Thailand', '66', '0000000000', 1),
(218, 'TG', 'Togo', '228', '0000000000', 1),
(219, 'TK', 'Tokelau', '690', '0000000000', 1),
(220, 'TO', 'Tonga', '676', '0000000000', 1),
(221, 'TT', 'Trinidad And Tobago', '1868', '0000000000', 1),
(222, 'TN', 'Tunisia', '216', '0000000000', 1),
(223, 'TR', 'Turkey', '90', '0000000000', 1),
(224, 'TM', 'Turkmenistan', '7370', '0000000000', 1),
(225, 'TC', 'Turks And Caicos Islands', '1649', '0000000000', 1),
(226, 'TV', 'Tuvalu', '688', '0000000000', 1),
(227, 'UG', 'Uganda', '256', '0000000000', 1),
(228, 'UA', 'Ukraine', '380', '0000000000', 1),
(229, 'AE', 'United Arab Emirates', '971', '0000000000', 1),
(230, 'GB', 'United Kingdom', '44', '0000000000', 1),
(231, 'US', 'United States', '1', '0000000000', 0),
(232, 'UM', 'United States Minor Outlying Islands', '1', '0000000000', 0),
(233, 'UY', 'Uruguay', '598', '0000000000', 1),
(234, 'UZ', 'Uzbekistan', '998', '0000000000', 1),
(235, 'VU', 'Vanuatu', '678', '0000000000', 1),
(236, 'VA', 'Vatican City State (Holy See)', '39', '0000000000', 1),
(237, 'VE', 'Venezuela', '58', '0000000000', 1),
(238, 'VN', 'Vietnam', '84', '0000000000', 1),
(239, 'VG', 'Virgin Islands (British)', '1284', '0000000000', 1),
(240, 'VI', 'Virgin Islands (US)', '1340', '0000000000', 1),
(241, 'WF', 'Wallis And Futuna Islands', '681', '0000000000', 1),
(242, 'EH', 'Western Sahara', '212', '0000000000', 1),
(243, 'YE', 'Yemen', '967', '0000000000', 0),
(244, 'YU', 'Yugoslavia', '38', '0000000000', 1),
(245, 'ZM', 'Zambia', '260', '0000000000', 1),
(246, 'ZW', 'Zimbabwe', '263', '0000000000', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `keywords`
--

CREATE TABLE `keywords` (
  `id` int(11) NOT NULL,
  `keyword` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `keywords`
--

INSERT INTO `keywords` (`id`, `keyword`, `user_id`) VALUES
(3, 13, 23),
(4, 12, 23),
(5, 9, 23),
(6, 11, 27),
(7, 14, 18),
(8, 15, 18),
(9, 3, 18);

-- --------------------------------------------------------

--
-- 테이블 구조 `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `noty_type` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `visible` enum('writer','reader','all','') NOT NULL DEFAULT 'all',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `notification`
--

INSERT INTO `notification` (`id`, `content_id`, `noty_type`, `type`, `comment`, `sender_id`, `user_id`, `visible`, `created_at`) VALUES
(1, 9, 'New', 'books', 'title Books is published', 0, 22, 'all', '2020-05-29 00:00:00'),
(2, 10, 'New', 'books', 'Test Books is published', 0, 22, 'all', '2020-06-16 09:58:21');

-- --------------------------------------------------------

--
-- 테이블 구조 `notification_read`
--

CREATE TABLE `notification_read` (
  `id` int(11) NOT NULL,
  `reader_id` int(11) NOT NULL,
  `noti_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `notification_read`
--

INSERT INTO `notification_read` (`id`, `reader_id`, `noti_id`) VALUES
(2, 18, 2),
(3, 18, 1),
(4, 27, 1),
(5, 38, 1),
(6, 27, 2);

-- --------------------------------------------------------

--
-- 테이블 구조 `prefered_books`
--

CREATE TABLE `prefered_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `purchased`
--

CREATE TABLE `purchased` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `reader_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `reader` int(11) NOT NULL,
  `aboutBook` text NOT NULL,
  `entertaining` tinyint(1) NOT NULL,
  `timepass` tinyint(1) NOT NULL,
  `gripping` tinyint(1) NOT NULL,
  `aboutAuthor` text NOT NULL,
  `author_rating` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `rating`
--

INSERT INTO `rating` (`id`, `rating`, `reader`, `aboutBook`, `entertaining`, `timepass`, `gripping`, `aboutAuthor`, `author_rating`, `content_id`, `created_at`) VALUES
(1, 5, 16, '', 1, 0, 1, 'author', 5, 2, '2020-05-20 12:03:47'),
(4, 5, 19, 'asdasaasd', 1, 0, 1, 'asdasd', 2, 2, '2020-05-22 10:49:54'),
(5, 4, 19, 'This book is very good', 1, 0, 1, 'I loke this author', 5, 2, '2020-05-22 10:59:49'),
(6, 5, 23, '', 1, 0, 1, '', 2, 2, '2020-05-30 05:26:41'),
(7, 5, 23, '', 1, 0, 1, '', 2, 2, '2020-05-30 05:26:58'),
(8, 5, 23, '', 1, 0, 1, '', 2, 2, '2020-05-30 05:27:28'),
(9, 5, 23, '', 1, 0, 1, '', 2, 2, '2020-05-30 05:27:46'),
(10, 4, 23, 'i like this book', 1, 0, 1, 'i lke this author', 5, 9, '2020-06-13 00:02:48'),
(11, 5, 26, 'ok', 0, 0, 1, 'ok', 2, 2, '2020-06-15 10:07:54'),
(12, 2, 27, '', 0, 0, 0, '', 2, 2, '2020-06-17 04:20:52'),
(13, 5, 27, '', 1, 0, 1, '', 2, 22, '2020-06-27 21:18:18'),
(14, 5, 27, 'good', 1, 0, 1, 'good', 2, 22, '2020-06-27 21:18:46'),
(15, 2, 27, '', 0, 0, 0, '', 2, 22, '2020-06-27 21:19:08'),
(16, 2, 27, '', 0, 0, 0, '', 2, 22, '2020-06-27 21:25:38');

-- --------------------------------------------------------

--
-- 테이블 구조 `reader_history`
--

CREATE TABLE `reader_history` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `reader_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `reader_history`
--

INSERT INTO `reader_history` (`id`, `content_id`, `reader_id`, `created_at`) VALUES
(1, 28, 23, '2020-06-27 13:01:40'),
(2, 2, 23, '2020-06-27 13:02:03'),
(3, 6, 23, '2020-06-27 13:02:26'),
(4, 9, 23, '2020-06-27 13:02:36'),
(5, 28, 27, '2020-06-27 13:38:09'),
(6, 22, 27, '2020-06-27 13:39:39'),
(7, 9, 27, '2020-06-27 13:48:26'),
(8, 2, 27, '2020-06-27 14:03:12');

-- --------------------------------------------------------

--
-- 테이블 구조 `rewards_history`
--

CREATE TABLE `rewards_history` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `type` enum('Earned','Burned','','') NOT NULL,
  `rewards` int(11) NOT NULL,
  `content_type` varchar(300) NOT NULL,
  `page` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `rewards_history`
--

INSERT INTO `rewards_history` (`id`, `content_id`, `user_id`, `comment`, `type`, `rewards`, `content_type`, `page`, `created_at`) VALUES
(43, 2, 23, 'Read AVENDERS', 'Earned', 12, 'books', 1, '2020-06-17 14:46:51'),
(44, 6, 23, 'Read React Native Programming', 'Earned', 12, 'article', 1, '2020-06-17 14:47:56'),
(45, 9, 23, 'Read title', 'Earned', 12, 'books', 308, '2020-06-17 14:49:13'),
(46, 2, 36, 'Read AVENDERS', 'Earned', 12, 'books', 1, '2020-06-17 23:54:29'),
(47, 2, 27, 'Read AVENDERS', 'Earned', 12, 'books', 1, '2020-06-18 09:16:42'),
(48, 2, 38, 'Read AVENDERS', 'Earned', 10, 'books', 1, '2020-06-18 09:28:31'),
(49, 2, 18, 'Read AVENDERS', 'Earned', 10, 'books', 1, '2020-06-21 06:26:31'),
(50, 28, 23, 'Read asdasdas', 'Earned', 10, 'article', 1, '2020-06-25 09:00:48'),
(51, 22, 27, 'Read The Crying Game From The Trees', 'Earned', 10, 'article', 1, '2020-06-27 21:16:40');

-- --------------------------------------------------------

--
-- 테이블 구조 `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `meta_key` varchar(40) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `setting`
--

INSERT INTO `setting` (`id`, `meta_key`, `meta_value`) VALUES
(1, 'content_price', '100'),
(2, 'content_service_number', '1526264582'),
(3, 'purchase_points', '100'),
(4, 'reward_points', '10'),
(5, 'point_cents', '15'),
(6, 'terms_condition', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.'),
(7, 'how_to_use', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.'),
(8, 'faqs', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.'),
(9, 'content_server_email', 'admin@bookramp.com'),
(10, 'profanity', 'Profanity Keywords');

-- --------------------------------------------------------

--
-- 테이블 구조 `settlement`
--

CREATE TABLE `settlement` (
  `id` int(11) NOT NULL,
  `content` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` enum('APPROVED','REJECTED','PENDING','') NOT NULL,
  `rewards` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `settlement`
--

INSERT INTO `settlement` (`id`, `content`, `author`, `amount`, `status`, `rewards`, `created_at`, `updated_at`) VALUES
(1, 2, 14, 80, 'APPROVED', 20, '2020-05-06 00:00:00', '2020-05-07 00:00:00'),
(7, 0, 18, 10, 'PENDING', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 0, 18, 10, 'PENDING', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 0, 18, 12, 'PENDING', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 0, 18, 12, 'PENDING', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `reader` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `status` enum('APPROVED','PENDING','REJECTED','') NOT NULL,
  `content` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `rewards` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `transaction`
--

INSERT INTO `transaction` (`id`, `reader`, `transaction_id`, `status`, `content`, `amount`, `rewards`, `created_at`, `updated_at`) VALUES
(1, 22, 123123123, 'APPROVED', 2, 12, 12, '2020-05-12 00:00:00', '2020-05-19 00:00:00'),
(4, 23, 0, 'APPROVED', 28, 0, 0, '2020-06-27 13:01:40', '2020-06-27 13:01:40'),
(5, 23, 0, 'APPROVED', 2, 0, 0, '2020-06-27 13:02:03', '2020-06-27 13:02:03'),
(6, 23, 0, 'APPROVED', 6, 0, 0, '2020-06-27 13:02:26', '2020-06-27 13:02:26'),
(7, 23, 0, 'APPROVED', 9, 0, 0, '2020-06-27 13:02:36', '2020-06-27 13:02:36'),
(8, 27, 0, 'APPROVED', 28, 0, 0, '2020-06-27 13:38:09', '2020-06-27 13:38:09'),
(9, 27, 0, 'APPROVED', 22, 0, 0, '2020-06-27 13:39:39', '2020-06-27 13:39:39'),
(10, 27, 0, 'APPROVED', 9, 0, 0, '2020-06-27 13:48:26', '2020-06-27 13:48:26'),
(11, 27, 0, 'APPROVED', 2, 0, 0, '2020-06-27 14:03:12', '2020-06-27 14:03:12');

-- --------------------------------------------------------

--
-- 테이블 구조 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `age_group` varchar(100) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `language` varchar(30) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `short_bio` text NOT NULL,
  `rewards` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `balance` float NOT NULL DEFAULT 0,
  `status` enum('ACTIVE','INACTIVE','APPROVED','REJECTED','UNDERREVIEW','UNVERIFIED') NOT NULL,
  `credential` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `user`
--

INSERT INTO `user` (`id`, `username`, `profile_pic`, `email`, `password`, `phone_number`, `dob`, `age_group`, `gender`, `country`, `city`, `language`, `user_type`, `short_bio`, `rewards`, `point`, `balance`, `status`, `credential`) VALUES
(14, 'user1', './uploads/user/user_1589229979.jpg', 'user1@outlook.com', 'fcea920f7412b5da7be0cf42b8c93759', '+12421231231233', '2020-02-23', '12~23', 'Male', 'BS', 'company', 'ar', 'writer', 'Dummy text is text that is used in the publishing industry or by web designers to occupy the space which will later be filled with  content. This is required when, for example, the final text is not yet available. Dummy text is also known as', 0, 2, 0, 'UNDERREVIEW', ''),
(16, 'user2', './uploads/user/user_1589259198.jpg', 'user2@outlook.com', 'd41d8cd98f00b204e9800998ecf8427e', '+123123123123', '2020-05-23', '12~23', 'Male', 'BS', 'city1', 'ar', 'reader', 'short bio example', 0, 0, 0, 'ACTIVE', ''),
(17, 'Admin', './uploads/user/user_1589616571.jpg', 'admin@bookramp.com', 'fcea920f7412b5da7be0cf42b8c93759', '+971+123123123', '1984-01-22', '18-25', 'Male', 'AE', 'BO', 'en', 'admin', 'I am Admin', 0, 0, 0, 'ACTIVE', ''),
(18, 'user1', './uploads/user/user_1589616571.jpg', 'aaa@aaaa.com', 'fcea920f7412b5da7be0cf42b8c93759', '+244123123123', '2020-05-14', '26-36', 'Male', 'AO', 'asdasdasd', 'en', 'writer', 'aaaaaaa', 10, 12, 12, 'APPROVED', ''),
(19, 'user5', 'uploads/user/user_1590246450.jpg', 'user3@outlook.com', 'fcea920f7412b5da7be0cf42b8c93759', '+3761231123123', '2020-05-04', '26-36', 'Male', 'AD', 'aasdsd', 'ar', 'reader', '', 0, 0, 0, 'ACTIVE', ''),
(20, 'Jhon', 'uploads/user/user_1590609342.jpg', 'jhondoe@outlook.com', 'fcea920f7412b5da7be0cf42b8c93759', '+1469476', '2020-05-21', '26-36', 'Male', 'US', 'Callifornia', 'en', 'writer', '', 0, 4, 0, 'UNDERREVIEW', '2928b66f6608ba1354925bdbc8e048a8'),
(22, 'user3', 'uploads/user/user_1590700997.jpg', 'user4@outlook.com', 'fcea920f7412b5da7be0cf42b8c93759', '+14694761748', '2020-05-05', '26-36', 'Male', 'US', 'aaaa', 'ar', 'reader', 'this is our list', 0, 0, 0, 'ACTIVE', 'd0240e7ecfd7b120d4ba2edb9395da93'),
(23, 'linqun', 'uploads/user/user_1592433654.jpg', 'aaa@aaaaa.com', 'fcea920f7412b5da7be0cf42b8c93759', '+2134694761750', '2020-05-12', '10~50', 'Male', 'DZ', 'callifornia', 'en', 'reader', 'aaaa', 46, 0, 0, 'ACTIVE', 'cce1826479d263b241a1429bdc8ea684'),
(25, 'lokj', '', 'aaa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '+14694761747', '2020-05-04', '26-36', 'Male', 'US', 'callifornia', 'ar', 'reader', '', 0, 0, 0, 'ACTIVE', 'c0e91851cbb2c5d64a5ac16e4fc090e6'),
(26, 'test12', 'uploads/user/user_1592183438.jpg', 'test12@gmail.com', '05a671c66aefea124cc08b76ea6d30bb', '+374undefined', '2020-06-15', '26-36', 'Male', 'AM', 'NY', 'ar', 'reader', '', 0, 0, 0, 'ACTIVE', ''),
(27, 'test15', 'uploads/user/user_1593194573.jpg', 'test15@gmail.com', '05a671c66aefea124cc08b76ea6d30bb', '+12064152149', '2020-06-15', '40-50', 'Male', 'US', 'ny', 'en', 'reader', '', 22, 0, 0, 'ACTIVE', '7479b4284ad29379c901ade00ce3433f'),
(34, 'aaaaaa', '', 'sssd@sss.com', 'fcea920f7412b5da7be0cf42b8c93759', '+14694761720', '2020-06-20', '26-36', 'Male', 'US', 'ssssss', 'ar', 'writer', '', 0, 0, 0, 'UNDERREVIEW', ''),
(36, 'Jhonmartin', '', 'jhonmartin1984@outlook.com', 'fcea920f7412b5da7be0cf42b8c93759', '+14694761749', '2020-06-19', '26-36', 'Male', 'US', 'California', 'en', 'writer', '', 12, 0, 0, 'ACTIVE', ''),
(37, 'asdas', '', 'aaa@dsddf.com', 'fcea920f7412b5da7be0cf42b8c93759', '+14156887444', '2020-06-20', '26-36', 'Male', 'US', 'sdfg', '', 'reader', '', 0, 0, 0, 'INACTIVE', ''),
(38, 'test20', './uploads/user/user_1593098808.png', 'test20@gmail.com', '05a671c66aefea124cc08b76ea6d30bb', '+1undefined', '2020-06-17', '18-25', 'Male', 'US', 'California ', 'en', 'writer', '', 10, 4, 0, 'APPROVED', ''),
(39, 'amal', '', 'amallu@gmail.com', 'fd6138204c4eb1dd19e63896c1557e27', '+971561992994', '2011-02-01', '40-50', 'Male', 'AE', 'Dubai ', 'ar', 'writer', '', 0, 0, 0, 'UNDERREVIEW', ''),
(40, 'apar', '', 'aparna13@hotmail.com', '68eacb97d86f0c4621fa2b0e17cabd8c', '+971561992996', '2020-06-19', '40-50', 'Male', 'AE', 'dubai', '', 'writer', '', 0, 0, 0, 'UNDERREVIEW', '9f54f5bf544aff0f101e341a8cf23625'),
(41, '', '', '', '', '', '0000-00-00', '', 'Male', '', '', '', '', '', 0, 0, 0, 'UNVERIFIED', ''),
(42, 'amit', '', 'amitmalhot45@gmail.com', 'fd6138204c4eb1dd19e63896c1557e27', '+971561992995', '2020-06-26', '40-50', 'Male', 'AE', 'dubai', '', 'reader', '', 0, 0, 0, 'INACTIVE', ''),
(43, 'test', '', 'test25@gmail.com', '05a671c66aefea124cc08b76ea6d30bb', '+17865067619', '2020-06-26', '26-36', 'Male', 'US', 'gu', '', 'writer', '', 0, 0, 0, 'UNDERREVIEW', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `reader_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `wishlist`
--

INSERT INTO `wishlist` (`id`, `content_id`, `reader_id`, `created_at`) VALUES
(21, 2, 36, '2020-06-17 23:53:42'),
(24, 2, 27, '2020-06-18 09:17:24'),
(25, 2, 38, '2020-06-18 09:28:04'),
(29, 2, 18, '2020-06-20 13:39:14'),
(30, 28, 23, '2020-06-25 09:00:32'),
(31, 22, 38, '2020-06-26 00:37:30'),
(32, 28, 38, '2020-06-26 00:38:29'),
(33, 9, 23, '2020-06-26 09:16:10'),
(34, 22, 27, '2020-06-27 03:00:44');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `available_keywords`
--
ALTER TABLE `available_keywords`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_code_index` (`code`);

--
-- 테이블의 인덱스 `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `notification_read`
--
ALTER TABLE `notification_read`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `prefered_books`
--
ALTER TABLE `prefered_books`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `purchased`
--
ALTER TABLE `purchased`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `reader_history`
--
ALTER TABLE `reader_history`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `rewards_history`
--
ALTER TABLE `rewards_history`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `settlement`
--
ALTER TABLE `settlement`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `available_keywords`
--
ALTER TABLE `available_keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- 테이블의 AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 테이블의 AUTO_INCREMENT `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 테이블의 AUTO_INCREMENT `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- 테이블의 AUTO_INCREMENT `keywords`
--
ALTER TABLE `keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 테이블의 AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `notification_read`
--
ALTER TABLE `notification_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `prefered_books`
--
ALTER TABLE `prefered_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `purchased`
--
ALTER TABLE `purchased`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 테이블의 AUTO_INCREMENT `reader_history`
--
ALTER TABLE `reader_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `rewards_history`
--
ALTER TABLE `rewards_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- 테이블의 AUTO_INCREMENT `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 테이블의 AUTO_INCREMENT `settlement`
--
ALTER TABLE `settlement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 테이블의 AUTO_INCREMENT `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- 테이블의 AUTO_INCREMENT `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

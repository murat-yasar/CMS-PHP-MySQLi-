-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 24, 2024 at 04:15 PM
-- Server version: 5.7.44
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms-php`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(3) NOT NULL,
  `category_name` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Web Design'),
(2, 'Web Development'),
(5, 'Programming'),
(27, 'DevOps'),
(31, 'Database'),
(33, 'UI/UX Design'),
(34, 'SQL');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_author` varchar(31) NOT NULL,
  `comment_email` varchar(63) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_status` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_date`, `comment_author`, `comment_email`, `comment_text`, `comment_status`) VALUES
(1, 12, '2024-09-12', 'Ihsan Melih', 'iko@gmail.com', 'What the Hell!?', 'unapproved'),
(4, 13, '2024-09-11', 'Orhan Mete', 'oko@gmail.com', 'Interesting...', 'approved'),
(18, 13, '2024-09-16', 'Memluk', 'm@m.com', 'Not that interesting...', 'approved'),
(34, 22, '2024-09-22', 'IMY', 'imy@mail.com', 'imy test', 'approved'),
(38, 21, '2024-09-23', 'IMY', 'imy@mail.com', 'IMY - test comment', 'unapproved');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(3) NOT NULL,
  `employee_name` varchar(31) NOT NULL,
  `employee_title` varchar(31) NOT NULL,
  `employee_img` text NOT NULL,
  `employee_date` date DEFAULT NULL,
  `employee_x` varchar(63) NOT NULL,
  `employee_linkedin` varchar(63) NOT NULL,
  `employee_facebook` varchar(63) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `employee_title`, `employee_img`, `employee_date`, `employee_x`, `employee_linkedin`, `employee_facebook`) VALUES
(1, 'Murat Yaşar', 'Lead Developer', 'muratyasar.jpeg', '2024-09-23', '', 'https://www.linkedin.com/in/murat-yasar/', ''),
(2, 'Jane Doe', 'Lead Marketer', 'employee-2.jpg', '2024-09-24', '', '', ''),
(3, 'Jenny Doe', 'Lead Designer', 'employee-3.jpg', '2024-09-24', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `portfolio_id` int(11) NOT NULL,
  `portfolio_name` varchar(31) NOT NULL,
  `portfolio_category` varchar(31) NOT NULL,
  `portfolio_img_sm` text NOT NULL,
  `portfolio_img_bg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`portfolio_id`, `portfolio_name`, `portfolio_category`, `portfolio_img_sm`, `portfolio_img_bg`) VALUES
(1, 'Start-Up Webpage', 'Web Development', '01-thumbnail.jpg', '01-full.jpg'),
(3, 'JavaScript (ES6)', 'Programming', '04-thumbnail.jpg', '04-full.jpg'),
(11, 'SQL', 'Database', '05-thumbnail.jpg', '06-full.jpg'),
(12, 'Linux', 'DevOps', '03-thumbnail.jpg', '03-full.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(15) NOT NULL,
  `post_category` varchar(31) NOT NULL,
  `post_title` varchar(100) NOT NULL,
  `post_author` varchar(100) NOT NULL,
  `post_date` date NOT NULL,
  `post_img` text NOT NULL,
  `post_text` text NOT NULL,
  `post_tags` text NOT NULL,
  `post_hits` int(15) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category`, `post_title`, `post_author`, `post_date`, `post_img`, `post_text`, `post_tags`, `post_hits`) VALUES
(12, 'UI/UX Design', 'Responsive Design', 'Murat Yaşar', '2024-09-09', 'post1.jpg', 'Responsive web design (RWD) or responsive design is an approach to web design that aims to make web pages render well on a variety of devices and window or screen sizes from minimum to maximum display size to ensure usability and satisfaction.\r\n\r\nBefore responsive web design became the standard approach for making websites work across different device types, web developers used to talk about mobile web design, mobile web development, or sometimes, mobile-friendly design. These are basically the same as responsive web design — the goals are to make sure that websites work well across devices with different physical attributes (screen size, resolution) in terms of layout, content (text and media), and performance.', 'Web development, responsive design', 13),
(13, 'Web Development', 'Search Engine Optimization (SEO)', 'Murat Yaşar', '2024-09-09', 'company.jpg', 'Search engine optimization (SEO) is the process of improving the quality and quantity of website traffic to a website or a web page from search engines. SEO targets unpaid traffic (known as \"natural\" or \"organic\" results) rather than direct traffic or paid traffic. Unpaid traffic may originate from different kinds of searches, including image search, video search, academic search, news search, and industry-specific vertical search engines.\r\n\r\nAs an Internet marketing strategy, SEO considers how search engines work, the computer-programmed algorithms that dictate search engine behavior, what people search for, the actual search terms or keywords typed into search engines, and which search engines are preferred by their targeted audience. SEO is performed because a website will receive more visitors from a search engine when websites rank higher on the search engine results page (SERP). These visitors can then potentially be converted into customers.', 'SEO, Web Development', 6),
(21, 'Web Development', 'JSON Web Token (JWT)', 'Orhan Mete', '2024-09-20', 'company.jpg', 'What is JSON Web Token?\r\n\r\nJSON Web Token (JWT) is an open standard (RFC 7519) that defines a compact and self-contained way for securely transmitting information between parties as a JSON object. This information can be verified and trusted because it is digitally signed. JWTs can be signed using a secret (with the HMAC algorithm) or a public/private key pair using RSA or ECDSA.\r\n\r\nAlthough JWTs can be encrypted to also provide secrecy between parties, we will focus on signed tokens. Signed tokens can verify the integrity of the claims contained within it, while encrypted tokens hide those claims from other parties. When tokens are signed using public/private key pairs, the signature also certifies that only the party holding the private key is the one that signed it.\r\nWhen should you use JSON Web Tokens?\r\n\r\nHere are some scenarios where JSON Web Tokens are useful:\r\n\r\n    Authorization: This is the most common scenario for using JWT. Once the user is logged in, each subsequent request will include the JWT, allowing the user to access routes, services, and resources that are permitted with that token. Single Sign On is a feature that widely uses JWT nowadays, because of its small overhead and its ability to be easily used across different domains.\r\n\r\n    Information Exchange: JSON Web Tokens are a good way of securely transmitting information between parties. Because JWTs can be signed—for example, using public/private key pairs—you can be sure the senders are who they say they are. Additionally, as the signature is calculated using the header and the payload, you can also verify that the content hasn\'t been tampered with.', 'JSON, JWT, Authentication', 4),
(22, 'DevOps', 'Git', 'Ihsan Melih', '2024-09-20', 'post1.jpg', 'Understanding Git: A Beginner’s Guide to Version Control\r\n\r\nIn today’s software development, version control is essential, and Git has emerged as one of the most popular tools for managing code. Whether you\'re a solo developer or part of a large team, Git helps keep track of code changes, collaborates with others, and ensures that nothing is ever lost. In this post, we’ll explore what Git is, how it works, and why it\'s a must-have for any developer.\r\nWhat is Git?\r\n\r\nGit is a distributed version control system (DVCS). It was created by Linus Torvalds in 2005 to handle projects like the Linux kernel. Since then, it has grown to become the industry standard for version control, mainly because of its flexibility, speed, and ability to support collaboration.\r\n\r\nWith Git, every developer working on a project has their own complete version of the project history, allowing for more robust and decentralized workflows. This is different from centralized systems like Subversion (SVN), where a single server holds the codebase.\r\nWhy Use Git?\r\n\r\n    Collaboration: Git makes collaboration seamless. You can work on different parts of a project with other developers without worrying about overwriting each other’s work. Merging changes from multiple people becomes easy and efficient.\r\n\r\n    Version Tracking: Git keeps a detailed history of every change made to the codebase. This allows developers to track what was changed, when, and by whom. It also makes it easy to revert to a previous version if necessary.\r\n\r\n    Branching: One of Git’s most powerful features is branching. Developers can create branches to work on features independently without affecting the main codebase. Once the feature is complete, they can merge it back.\r\n\r\n    Speed: Since Git is distributed, most operations are local, making them incredibly fast compared to centralized systems.\r\n\r\nUnderstanding Git: A Beginner’s Guide to Version Control\r\n\r\nIn today’s software development, version control is essential, and Git has emerged as one of the most popular tools for managing code. Whether you\'re a solo developer or part of a large team, Git helps keep track of code changes, collaborates with others, and ensures that nothing is ever lost. In this post, we’ll explore what Git is, how it works, and why it\'s a must-have for any developer.\r\nWhat is Git?\r\n\r\nGit is a distributed version control system (DVCS). It was created by Linus Torvalds in 2005 to handle projects like the Linux kernel. Since then, it has grown to become the industry standard for version control, mainly because of its flexibility, speed, and ability to support collaboration.\r\n\r\nWith Git, every developer working on a project has their own complete version of the project history, allowing for more robust and decentralized workflows. This is different from centralized systems like Subversion (SVN), where a single server holds the codebase.\r\nWhy Use Git?\r\n\r\n    Collaboration: Git makes collaboration seamless. You can work on different parts of a project with other developers without worrying about overwriting each other’s work. Merging changes from multiple people becomes easy and efficient.\r\n\r\n    Version Tracking: Git keeps a detailed history of every change made to the codebase. This allows developers to track what was changed, when, and by whom. It also makes it easy to revert to a previous version if necessary.\r\n\r\n    Branching: One of Git’s most powerful features is branching. Developers can create branches to work on features independently without affecting the main codebase. Once the feature is complete, they can merge it back.\r\n\r\n    Speed: Since Git is distributed, most operations are local, making them incredibly fast compared to centralized systems.', 'git, github', 49);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `user_name` varchar(31) NOT NULL,
  `user_password` varchar(31) NOT NULL,
  `user_email` varchar(63) NOT NULL,
  `user_role` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_email`, `user_role`) VALUES
(1, 'Murat Yaşar', 'my123', 'my@mail.com', 'admin'),
(2, 'Ihsan Melih', 'imy123', 'imy@mail.com', 'member'),
(4, 'Orhan Mete', 'omy123', 'omy@mail.com', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`portfolio_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `portfolio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE IF NOT EXISTS `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `content` text NOT NULL,
    `author` varchar(255) NOT NULL,
    `date` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `date`) VALUES
(1, 'Hello World', 'This is the first post', 'admin', '2013-01-01 00:00:00'),
(2, 'Hello Again', 'This is the second post', 'admin', '2013-01-02 00:00:00');
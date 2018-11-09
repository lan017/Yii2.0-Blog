/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2018-11-06 17:05:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email_validate_token` varchar(255) DEFAULT NULL COMMENT '邮箱验证token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT '角色等级',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `vip_lv` int(11) DEFAULT '0' COMMENT 'vip等级',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'bluehouse', '4UkVZds3IpA2Upmo8qc67pg82E57o7k3', '$2y$13$AIKcpRjcaKADvTendlEzZuKkS.OxGTJz.dENfj.KSIgiMXS6IA8dS', null, null, 'nie_yunfei@163.com', '10', '10', null, '0', '1540365114', '1540365114');

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog
-- ----------------------------

-- ----------------------------
-- Table structure for cats
-- ----------------------------
DROP TABLE IF EXISTS `cats`;
CREATE TABLE `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `cat_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of cats
-- ----------------------------
INSERT INTO `cats` VALUES ('1', 'PHP技术');
INSERT INTO `cats` VALUES ('2', 'JAVA技术');
INSERT INTO `cats` VALUES ('3', 'LNMP架构');

-- ----------------------------
-- Table structure for feeds
-- ----------------------------
DROP TABLE IF EXISTS `feeds`;
CREATE TABLE `feeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='聊天信息表';

-- ----------------------------
-- Records of feeds
-- ----------------------------
INSERT INTO `feeds` VALUES ('10', '563', '测试留言', '1540787383');
INSERT INTO `feeds` VALUES ('11', '563', '最新发布', '1540787392');
INSERT INTO `feeds` VALUES ('12', '563', '异步加载数据', '1540787397');
INSERT INTO `feeds` VALUES ('13', '563', '再追加1条', '1540787406');
INSERT INTO `feeds` VALUES ('14', '563', '再追加一条', '1540787411');
INSERT INTO `feeds` VALUES ('15', '563', '再追加一条', '1540787412');
INSERT INTO `feeds` VALUES ('16', '563', '再追加一条', '1540787414');
INSERT INTO `feeds` VALUES ('17', '563', '再追加一条', '1540787416');
INSERT INTO `feeds` VALUES ('18', '563', '再追加一条', '1540787418');
INSERT INTO `feeds` VALUES ('19', '563', '测试', '1540880175');
INSERT INTO `feeds` VALUES ('20', '563', '再次测试', '1540886463');

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1540883240');
INSERT INTO `migration` VALUES ('m181030_071821_create_blog_table', '1540884011');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `summary` varchar(255) DEFAULT NULL COMMENT '摘要',
  `content` text COMMENT '内容',
  `label_img` varchar(255) DEFAULT NULL COMMENT '标签图',
  `cat_id` int(11) DEFAULT NULL COMMENT '分类id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `is_valid` tinyint(1) DEFAULT '0' COMMENT '是否有效：0-未发布 1-已发布',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_cat_valid` (`cat_id`,`is_valid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='文章主表';

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('7', '第一篇测试文章', '你一定可以的，加油！', '<p>你一定可以的，加油！</p>', '/image/20181026/1540546491275446.png', '1', '563', 'test123', '1', '1540546754', '1540546754');
INSERT INTO `posts` VALUES ('9', '这是第二篇文章', '吃了吗', '<p>吃了吗</p>', '/image/20181027/1540608732486689.png', '2', '563', 'test123', '1', '1540609061', '1540609061');
INSERT INTO `posts` VALUES ('10', '第3篇测试文章', 'dsfadsfsafas', '<p>dsfadsfsafas</p>', '/image/20181027/1540609274899019.png', '1', '563', 'test123', '1', '1540609284', '1540609284');
INSERT INTO `posts` VALUES ('11', '第4篇文章', '的说法第三方', '<p>的说法第三方</p>', '/image/20181027/1540632682387630.png', '1', '563', 'test123', '1', '1540632691', '1540632691');
INSERT INTO `posts` VALUES ('12', '第5篇文章', '测试内容', '<p>测试内容</p>', '/image/20181029/1540786019106421.png', '2', '563', 'test123', '1', '1540786032', '1540786032');
INSERT INTO `posts` VALUES ('13', '第6篇测试文章', 'sdfadsf&nbsp;', '<p>sdfadsf&nbsp;</p>', '/image/20181029/1540786109107252.png', '1', '563', 'test123', '1', '1540786116', '1540786116');
INSERT INTO `posts` VALUES ('15', ' 第6篇测试文章', '这是一个测试内容', '<p>这是一个测试内容</p>', '/image/20181029/1540788338127860.png', '1', '563', 'test123', '1', '1540788397', '1540788397');
INSERT INTO `posts` VALUES ('16', '第7篇测试文章', '测试文章', '<p>测试文章</p>', '/image/20181029/1540788440722934.png', '1', '563', 'test123', '1', '1540788455', '1540788455');
INSERT INTO `posts` VALUES ('17', '第8篇测试文章', '欢迎加入互助交流群', '<p>欢迎加入互助交流群</p>', '/image/20181030/1540880203705850.png', '1', '563', 'test123', '1', '1540880219', '1540880219');

-- ----------------------------
-- Table structure for post_extends
-- ----------------------------
DROP TABLE IF EXISTS `post_extends`;
CREATE TABLE `post_extends` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `post_id` int(11) DEFAULT NULL COMMENT '文章id',
  `browser` int(11) DEFAULT '0' COMMENT '浏览量',
  `collect` int(11) DEFAULT '0' COMMENT '收藏量',
  `praise` int(11) DEFAULT '0' COMMENT '点赞',
  `comment` int(11) DEFAULT '0' COMMENT '评论',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='文章扩展表';

-- ----------------------------
-- Records of post_extends
-- ----------------------------
INSERT INTO `post_extends` VALUES ('38', '13', '10', '0', '0', '0');
INSERT INTO `post_extends` VALUES ('39', '11', '3', '0', '0', '0');
INSERT INTO `post_extends` VALUES ('40', '9', '2', '0', '0', '0');
INSERT INTO `post_extends` VALUES ('41', '7', '4', '0', '0', '0');
INSERT INTO `post_extends` VALUES ('42', '15', '1', '0', '0', '0');
INSERT INTO `post_extends` VALUES ('43', '16', '1', '0', '0', '0');
INSERT INTO `post_extends` VALUES ('44', '17', '3', '0', '0', '0');

-- ----------------------------
-- Table structure for relation_post_tags
-- ----------------------------
DROP TABLE IF EXISTS `relation_post_tags`;
CREATE TABLE `relation_post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `post_id` int(11) DEFAULT NULL COMMENT '文章ID',
  `tag_id` int(11) DEFAULT NULL COMMENT '标签ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_id` (`post_id`,`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文章和标签关系表';

-- ----------------------------
-- Records of relation_post_tags
-- ----------------------------
INSERT INTO `relation_post_tags` VALUES ('1', '15', '2');
INSERT INTO `relation_post_tags` VALUES ('2', '16', '1');
INSERT INTO `relation_post_tags` VALUES ('3', '17', '3');

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `tag_name` varchar(255) DEFAULT NULL COMMENT '标签名称',
  `post_num` int(11) DEFAULT '0' COMMENT '关联文章数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_name` (`tag_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='标签表';

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('1', '最新tag', '2');
INSERT INTO `tags` VALUES ('2', '测试', '1');
INSERT INTO `tags` VALUES ('3', 'QQ群', '1');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email_validate_token` varchar(255) DEFAULT NULL COMMENT '邮箱验证token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT '角色等级',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `vip_lv` int(11) DEFAULT '0' COMMENT 'vip等级',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=564 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('560', 'bluehouse', '4UkVZds3IpA2Upmo8qc67pg82E57o7k3', '$2y$13$AIKcpRjcaKADvTendlEzZuKkS.OxGTJz.dENfj.KSIgiMXS6IA8dS', null, null, 'nie_yunfei@163.com', '10', '10', null, '0', '1540365114', '1540365114');
INSERT INTO `user` VALUES ('561', 'test', '1rdQ2YWyMUqwQQbx7O9Vg8Ro6KGc17SO', '$2y$13$NJsr3vC/.n1pPADsnvXLFeJ6rLPEFyGyXQtlqDhxAmqGBSkezRbOO', null, null, 'test@123.com', '10', '10', null, '0', '1540369929', '1540369929');
INSERT INTO `user` VALUES ('562', 'test2', 'qx3uW5BRk0p-irdYdeb7ZZalfOMyJpFg', '$2y$13$dTNJ79MsnvCWwQsn.NimQe/U06iEToP2SgfIv3fk7Ry4lzoha/LLG', null, null, 'nie_yunfei@126.com', '10', '10', null, '0', '1540371129', '1540371129');
INSERT INTO `user` VALUES ('563', 'test123', 'OP5XQ8aZjVupTKdPEuocj_ffDhn1UsF2', '$2y$13$PzS84FRccgaLdNWev.ppDOGY2YPTpiyw00wIqUX4px9ukn9h2AJVq', null, null, 'nie_yunfei@123.com', '10', '10', null, '0', '1540375216', '1540375216');

-- ----------------------------
-- Table structure for user_backend
-- ----------------------------
DROP TABLE IF EXISTS `user_backend`;
CREATE TABLE `user_backend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_backend
-- ----------------------------

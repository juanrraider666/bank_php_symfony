/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : db_bank_symfony

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 30/07/2021 20:27:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `opened_date` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `IDX_7D3656A4C6798DB`(`account_type_id`) USING BTREE,
  CONSTRAINT `FK_7D3656A4C6798DB` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES (1, 1, '19032934', '2021-07-29', 1, 0);
INSERT INTO `account` VALUES (2, 1, '23994232', '2021-07-30', 1, 200);
INSERT INTO `account` VALUES (4, 1, '2345345', '2021-07-30', 1, 100);

-- ----------------------------
-- Table structure for account_type
-- ----------------------------
DROP TABLE IF EXISTS `account_type`;
CREATE TABLE `account_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of account_type
-- ----------------------------
INSERT INTO `account_type` VALUES (1, 'Ahorros', 'Cuenta bancaria nomina');

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `customer_type_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_became_customer` date NULL DEFAULT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `IDX_81398E09A76ED395`(`user_id`) USING BTREE,
  INDEX `IDX_81398E09D991282D`(`customer_type_id`) USING BTREE,
  INDEX `IDX_81398E099B6B5FBA`(`account_id`) USING BTREE,
  CONSTRAINT `FK_81398E099B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_81398E09A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_81398E09D991282D` FOREIGN KEY (`customer_type_id`) REFERENCES `customer_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1, 1, 1, 1, 'Juan', '13923', 'j@gmail.com', '2021-07-29', NULL);
INSERT INTO `customer` VALUES (2, 1, 1, 2, 'Juan', '123', 'j@gmail.com', '2021-07-30', NULL);
INSERT INTO `customer` VALUES (5, 2, 1, 4, 'PEPE', '123', 'p@gmail.com', '2021-07-30', NULL);

-- ----------------------------
-- Table structure for customer_purchase
-- ----------------------------
DROP TABLE IF EXISTS `customer_purchase`;
CREATE TABLE `customer_purchase`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `quantity` double NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `IDX_4DD292149395C3F3`(`customer_id`) USING BTREE,
  CONSTRAINT `FK_4DD292149395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_purchase
-- ----------------------------
INSERT INTO `customer_purchase` VALUES (31, 1, '2021-07-31', 1);
INSERT INTO `customer_purchase` VALUES (32, 1, '2021-07-31', 1);

-- ----------------------------
-- Table structure for customer_type
-- ----------------------------
DROP TABLE IF EXISTS `customer_type`;
CREATE TABLE `customer_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_type
-- ----------------------------
INSERT INTO `customer_type` VALUES (1, 'Natural', 'Cliente natural');

-- ----------------------------
-- Table structure for transaction
-- ----------------------------
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `transaction_type_id` int(11) NOT NULL,
  `date` date NULL DEFAULT NULL,
  `amount` double NOT NULL,
  `control_number` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `IDX_723705D1558FBEB9`(`purchase_id`) USING BTREE,
  INDEX `IDX_723705D19B6B5FBA`(`account_id`) USING BTREE,
  INDEX `IDX_723705D1B3E6B071`(`transaction_type_id`) USING BTREE,
  CONSTRAINT `FK_723705D1558FBEB9` FOREIGN KEY (`purchase_id`) REFERENCES `customer_purchase` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_723705D19B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_723705D1B3E6B071` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaction
-- ----------------------------
INSERT INTO `transaction` VALUES (30, 31, 2, 1, '2021-07-31', 50, 'BNKOCAL-23994232--310721-50');
INSERT INTO `transaction` VALUES (31, 32, 2, 1, '2021-07-31', 50, 'BNKOCAL-23994232--310721-50');

-- ----------------------------
-- Table structure for transaction_type
-- ----------------------------
DROP TABLE IF EXISTS `transaction_type`;
CREATE TABLE `transaction_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaction_type
-- ----------------------------
INSERT INTO `transaction_type` VALUES (1, 'Credito', 'credito');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `UNIQ_8D93D649D17F50A6`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, '123', '[\"ROLE_USER\"]', '$2y$13$3PbR3BaOAEY8a4Uysra82O8ACLRIfolZb3gkWM55hSC9abdDLk2E6');
INSERT INTO `user` VALUES (2, '1234', '[\"ROLE_USER\"]', '$2y$13$3PbR3BaOAEY8a4Uysra82O8ACLRIfolZb3gkWM55hSC9abdDLk2E6');

SET FOREIGN_KEY_CHECKS = 1;

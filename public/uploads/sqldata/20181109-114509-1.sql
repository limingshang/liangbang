-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 3306
-- Database : ds_cms
-- 
-- Part : #1
-- Date : 2018-11-09 11:45:09
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `ds_admin`
-- -----------------------------
DROP TABLE IF EXISTS `ds_admin`;
CREATE TABLE `ds_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员自增ID',
  `admin_name` varchar(20) NOT NULL COMMENT '管理员名称',
  `admin_password` varchar(32) NOT NULL COMMENT '管理员密码',
  `admin_add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `admin_login_time` int(11) NOT NULL COMMENT '登录时间',
  `admin_login_num` int(11) NOT NULL COMMENT '登录次数',
  `admin_is_super` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否超级管理员',
  `admin_group_id` smallint(6) DEFAULT '0' COMMENT '权限组ID',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- -----------------------------
-- Records of `ds_admin`
-- -----------------------------
INSERT INTO `ds_admin` VALUES ('1', 'admin', '7fef6171469e80d32c0559f88b377245', '0', '1541732225', '5', '1', '0');

-- -----------------------------
-- Table structure for `ds_admingroup`
-- -----------------------------
DROP TABLE IF EXISTS `ds_admingroup`;
CREATE TABLE `ds_admingroup` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限自增id',
  `group_name` varchar(50) DEFAULT NULL COMMENT '权限组名',
  `group_limits` text COMMENT '权限组序列',
  `lang` varchar(50) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员权限组表';

-- -----------------------------
-- Records of `ds_admingroup`
-- -----------------------------
INSERT INTO `ds_admingroup` VALUES ('1', '超级管理员', 'C48qI6rnxvVd_0hx3RqzPQ7FzMtkk-DCg5yxjP7HMRrtqXuY3Bi6SBDlMHT63bP8ZKY9kn-SSWASFZV5HdRcxcTtYWBzCg7z9YPLDlLMxmXd4aBjm2BSNpRaLlKL9rYOwjAS6SASRZV5TbSL9dYNgZEA6WFCZXR6PMRrtqXuY2BjGNAylZV4LYOc9kUNgpEAuFFiZbOLLSRbhzLN4rEAmNDihwJr7OSLtrVNkjEBOWBz9jTL7LT8NzLN0p_TONFDZwK7DYR7lrVNkjDCaF4DjBcQLr5SLlkWu4eAyuRAStnRqzQ', 'zh-cn');
INSERT INTO `ds_admingroup` VALUES ('2', '普通管理员', 'l35b0g8P5M_c1rlt0aeOCD_1U9fkXCt1mqaiXB0l7HvsbFIdZs1KqWB0JrJvkaC9tZ92qiaBD1KE_4NIr1e0buNAjJ5Ig0k8dxOy7uk9UhHIP4NFNZ8y6-dDTpUAP8cG9xY06qWAD19LuAaFM9Q26eMHxdKJvMLEs9N0qqbEkJZIQ4RBcZP4o2XAktFF_gcIqhL2KKPAEpBHfgk585g4oWRDTFU_goNFMtez6iWHyxKFgwXG9pM27Kk4DlMGAARGtNmtruXDDVMG_kWHsNL0LyQCEJoIPkVEd5T0aeVADRLHfgP', 'zh-cn');
INSERT INTO `ds_admingroup` VALUES ('3', '网站管理员', '-bb8W236CoZ2AuveKRrwYidmFEpFlO8kRwaoElPO-_riPOmP_n3Rq53LOn2TZZwh_kYgsmWgrWuXN-rMeU1iKkMRrC5PfH1T8oAgeiyMpNqPLBio2MaSejUhfCe', 'zh-cn');

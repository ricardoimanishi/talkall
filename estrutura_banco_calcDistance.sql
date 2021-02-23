Estrutura da Tabela do Banco
-- ----------------------------
-- Table structure for lojas
-- ----------------------------
DROP TABLE IF EXISTS `lojas`;
CREATE TABLE `lojas`  (
  `cod` int(255) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `logradouro` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bairro` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `numero` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `localidade` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `uf` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cep` varchar(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'CURRENT_TIMESTAMP',
  PRIMARY KEY (`cod`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lojas
-- ----------------------------
INSERT INTO `lojas` VALUES (1, 'Loja 1', 'R. Rouxinol', 'Jd. Bandeirantes', '383', 'Arapontas', 'PR', '86703010', '2021-02-23 10:16:46', '2021-02-23 11:35:34');
INSERT INTO `lojas` VALUES (2, 'Loja 2', 'R. Falcão', NULL, '930', 'Arapongas', 'PR', '86700140', '2021-02-23 10:14:33', NULL);
INSERT INTO `lojas` VALUES (3, 'Loja 3', 'Av. Dez de Dezembro', 'Fraternidade', '1860', 'Londrina', 'PR', '86010250', '2021-02-23 10:05:54', '2021-02-23 11:35:38');

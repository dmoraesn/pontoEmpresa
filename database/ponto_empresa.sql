-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para ponto_empresa
CREATE DATABASE IF NOT EXISTS `ponto_empresa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `ponto_empresa`;

-- Copiando estrutura para tabela ponto_empresa.abonos
CREATE TABLE IF NOT EXISTS `abonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `minutos` int(11) NOT NULL DEFAULT 0,
  `motivo` varchar(255) DEFAULT NULL,
  `tipo` enum('abonado','atestado','banco_de_horas','outros') NOT NULL DEFAULT 'abonado',
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_usuario_data` (`usuario_id`,`data`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.abonos: ~4 rows (aproximadamente)
DELETE FROM `abonos`;
INSERT INTO `abonos` (`id`, `usuario_id`, `data`, `minutos`, `motivo`, `tipo`, `criado_em`) VALUES
	(1, 2, '2025-09-12', 60, 'Consulta médica', 'atestado', '2025-09-13 15:16:07'),
	(8, 1, '2025-09-14', 360, 'FOLGA TRE', 'abonado', '2025-09-14 20:53:49'),
	(9, 6, '2025-09-15', 360, 'Doença', 'abonado', '2025-09-15 07:23:00'),
	(10, 6, '2025-09-15', 360, 'Atestado Médico', 'abonado', '2025-09-15 23:11:11'),
	(11, 1, '2025-09-10', 360, 'FOLGA TRE', 'abonado', '2025-09-16 10:24:12');

-- Copiando estrutura para tabela ponto_empresa.afastamentos
CREATE TABLE IF NOT EXISTS `afastamentos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `afastamentos_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `afastamentos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.afastamentos: ~19 rows (aproximadamente)
DELETE FROM `afastamentos`;
INSERT INTO `afastamentos` (`id`, `usuario_id`, `tipo`, `data_inicio`, `data_fim`, `observacao`, `created_at`, `updated_at`) VALUES
	(1, 1, 'FÉRIAS', '2024-12-31', '2025-02-01', 'DESCANSO REMUNERADO', '2025-09-16 15:05:40', '2025-09-16 16:14:56'),
	(5, 11, 'FÉRIAS', '2025-07-12', NULL, NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(6, 12, 'FÉRIAS', '2025-08-10', '2025-11-19', 'A sequi optio ea quis doloremque est.', '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(7, 13, 'LICENÇA MÉDICA', '2025-09-12', NULL, 'Quo et exercitationem aspernatur minima aliquam illo.', '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(8, 14, 'LICENÇA MÉDICA', '2025-07-15', NULL, NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(9, 15, 'OUTRO', '2025-06-19', NULL, 'Alias culpa nihil cum non et.', '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(10, 16, 'LICENÇA MÉDICA', '2025-06-27', NULL, NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(11, 17, 'LICENÇA MÉDICA', '2025-05-12', '2025-11-20', NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(12, 18, 'OUTRO', '2025-04-06', NULL, NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(13, 19, 'OUTRO', '2025-09-09', NULL, 'Error laudantium nostrum rerum soluta in vero.', '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(14, 20, 'LICENÇA MATERNIDADE', '2025-06-19', NULL, 'Non repellat quia qui cumque.', '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(15, 21, 'LICENÇA MÉDICA', '2025-09-03', '2025-10-18', NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(16, 22, 'OUTRO', '2025-03-19', '2025-11-29', 'Error consequuntur dolores aspernatur iure eveniet nam qui.', '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(17, 23, 'LICENÇA MÉDICA', '2025-08-15', '2025-11-08', NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(18, 24, 'LICENÇA MATERNIDADE', '2025-03-17', '2025-12-11', 'Similique non labore voluptatem necessitatibus consequatur quos et tempora.', '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(19, 25, 'LICENÇA MATERNIDADE', '2025-08-04', '2025-11-05', NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(20, 26, 'OUTRO', '2025-04-07', '2025-11-03', NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48'),
	(21, 27, 'FÉRIAS', '2025-07-20', NULL, NULL, '2025-09-16 15:36:48', '2025-09-16 15:36:48');

-- Copiando estrutura para tabela ponto_empresa.ajustes_marcacao
CREATE TABLE IF NOT EXISTS `ajustes_marcacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marcacao_id` bigint(20) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `data_hora_anterior` datetime DEFAULT NULL,
  `data_hora_novo` datetime DEFAULT NULL,
  `motivo` varchar(250) NOT NULL,
  `feito_por` varchar(120) NOT NULL,
  `feito_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `marcacao_id` (`marcacao_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `ajustes_marcacao_ibfk_1` FOREIGN KEY (`marcacao_id`) REFERENCES `marcacoes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.ajustes_marcacao: ~0 rows (aproximadamente)
DELETE FROM `ajustes_marcacao`;

-- Copiando estrutura para tabela ponto_empresa.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.cache: ~0 rows (aproximadamente)
DELETE FROM `cache`;

-- Copiando estrutura para tabela ponto_empresa.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.cache_locks: ~0 rows (aproximadamente)
DELETE FROM `cache_locks`;

-- Copiando estrutura para tabela ponto_empresa.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.failed_jobs: ~0 rows (aproximadamente)
DELETE FROM `failed_jobs`;

-- Copiando estrutura para tabela ponto_empresa.feriados
CREATE TABLE IF NOT EXISTS `feriados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `tipo` enum('nacional','estadual','municipal','empresa') NOT NULL DEFAULT 'nacional',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_data` (`data`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.feriados: ~0 rows (aproximadamente)
DELETE FROM `feriados`;

-- Copiando estrutura para tabela ponto_empresa.ferias
CREATE TABLE IF NOT EXISTS `ferias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `observacao` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ferias_usuario_fk` (`usuario_id`),
  CONSTRAINT `ferias_usuario_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.ferias: ~0 rows (aproximadamente)
DELETE FROM `ferias`;

-- Copiando estrutura para tabela ponto_empresa.horarios
CREATE TABLE IF NOT EXISTS `horarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `carga_horas` int(11) NOT NULL,
  `hora_entrada_prevista` time NOT NULL,
  `hora_saida_prevista` time NOT NULL,
  `intervalo_minimo_minutos` int(11) DEFAULT 60,
  `vigente_desde` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_horarios_usuario` (`usuario_id`),
  CONSTRAINT `fk_horarios_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.horarios: ~2 rows (aproximadamente)
DELETE FROM `horarios`;
INSERT INTO `horarios` (`id`, `usuario_id`, `carga_horas`, `hora_entrada_prevista`, `hora_saida_prevista`, `intervalo_minimo_minutos`, `vigente_desde`, `created_at`, `updated_at`) VALUES
	(2, 6, 6, '06:00:00', '12:00:00', 15, '2025-01-01', '2025-09-15 22:31:40', '2025-09-15 22:38:57');

-- Copiando estrutura para tabela ponto_empresa.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.jobs: ~0 rows (aproximadamente)
DELETE FROM `jobs`;

-- Copiando estrutura para tabela ponto_empresa.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.job_batches: ~0 rows (aproximadamente)
DELETE FROM `job_batches`;

-- Copiando estrutura para tabela ponto_empresa.marcacoes
CREATE TABLE IF NOT EXISTS `marcacoes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `tipo` enum('Entrada','Saída') NOT NULL,
  `data_hora` datetime NOT NULL,
  `origem` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_usuario_data` (`usuario_id`,`data_hora`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.marcacoes: ~27 rows (aproximadamente)
DELETE FROM `marcacoes`;
INSERT INTO `marcacoes` (`id`, `usuario_id`, `tipo`, `data_hora`, `origem`) VALUES
	(1, 1, 'Entrada', '2025-09-12 08:05:00', 'app'),
	(2, 1, 'Saída', '2025-09-12 12:00:00', 'app'),
	(3, 1, 'Entrada', '2025-09-12 13:00:00', 'app'),
	(4, 1, 'Saída', '2025-09-12 17:10:00', 'app'),
	(5, 2, 'Entrada', '2025-09-12 09:00:00', 'app'),
	(6, 2, 'Saída', '2025-09-12 18:00:00', 'app'),
	(7, 3, 'Entrada', '2025-09-11 08:30:00', 'app'),
	(8, 3, 'Saída', '2025-09-11 17:30:00', 'app'),
	(14, 3, 'Entrada', '2025-09-14 21:04:00', 'manual'),
	(28, 1, 'Entrada', '2025-09-15 08:13:00', 'ajuste_dashboard'),
	(29, 3, 'Entrada', '2025-09-15 12:32:00', 'ajuste_dashboard'),
	(30, 3, 'Saída', '2025-09-15 15:00:00', 'ajuste_dashboard'),
	(31, 5, 'Entrada', '2025-09-15 08:00:00', 'ajuste_dashboard'),
	(37, 1, 'Entrada', '2025-09-15 08:13:00', 'manual_admin'),
	(38, 4, 'Entrada', '2025-09-15 07:00:00', 'manual_admin'),
	(40, 1, 'Saída', '2025-09-15 19:40:00', 'manual_admin'),
	(41, 2, 'Entrada', '2025-09-15 08:00:00', 'manual_admin'),
	(42, 2, 'Saída', '2025-09-15 14:00:00', 'manual_admin'),
	(45, 6, 'Entrada', '2025-09-16 05:22:00', 'manual_admin'),
	(46, 6, 'Entrada', '2025-09-16 15:22:00', 'manual_admin'),
	(48, 6, 'Entrada', '2025-09-15 10:00:00', 'manual_admin'),
	(49, 6, 'Entrada', '2025-09-15 15:00:00', 'manual_admin'),
	(50, 6, 'Entrada', '2025-09-16 15:00:00', 'manual_admin'),
	(52, 6, 'Entrada', '2025-09-01 15:00:00', 'manual_admin'),
	(53, 6, 'Saída', '2025-09-01 20:00:00', 'manual_admin'),
	(54, 1, 'Entrada', '2025-09-16 12:50:00', 'manual_admin'),
	(55, 1, 'Saída', '2025-09-16 20:45:00', 'manual_admin');

-- Copiando estrutura para tabela ponto_empresa.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.migrations: ~40 rows (aproximadamente)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_09_16_114749_create_afastamentos_table', 2),
	(5, '2025_09_17_030806_create_personal_access_tokens_table', 3),
	(6, '2025_09_17_030832_add_password_to_usuarios_table', 4),
	(7, '2025_09_17_122550_add_password_column_to_usuarios_table', 5),
	(8, '2025_09_17_124721_create_pontos_table', 6),
	(9, '2025_09_13_175125_create_ajuste_marcacaos_table', 3),
	(10, '2025_09_13_175125_create_marcacaos_table', 3),
	(11, '2025_09_13_175125_create_ajuste_marcacaos_table', 3),
	(12, '2025_09_13_175125_create_marcacaos_table', 3),
	(13, '2025_09_13_175126_create_abonos_table', 3),
	(14, '2025_09_13_175126_create_horarios_table', 3),
	(15, '2025_09_13_175127_create_feriados_table', 3),
	(16, '2025_09_13_175125_create_ajuste_marcacaos_table', 3),
	(17, '2025_09_13_175125_create_marcacaos_table', 3),
	(18, '2025_09_13_175126_create_abonos_table', 3),
	(19, '2025_09_13_175126_create_horarios_table', 3),
	(20, '2025_09_13_175127_create_feriados_table', 3),
	(21, '2025_09_13_183844_create_personal_access_tokens_table', 3),
	(22, '2025_09_14_201745_alter_abonos_add_tipo_minutos', 7),
	(23, '2025_09_18_215238_create_personal_access_tokens_table', 3),
	(24, '2025_09_13_175125_create_ajuste_marcacaos_table', 3),
	(25, '2025_09_13_175125_create_marcacaos_table', 3),
	(26, '2025_09_13_175126_create_abonos_table', 3),
	(27, '2025_09_13_175126_create_horarios_table', 3),
	(28, '2025_09_13_175127_create_feriados_table', 3),
	(29, '2025_09_18_215238_create_personal_access_tokens_table', 3),
	(30, '2025_09_13_175125_create_ajuste_marcacaos_table', 3),
	(31, '2025_09_13_175125_create_marcacaos_table', 3),
	(32, '2025_09_13_175126_create_abonos_table', 3),
	(33, '2025_09_13_175126_create_horarios_table', 3),
	(34, '2025_09_13_175127_create_feriados_table', 3),
	(35, '2025_09_13_183844_create_personal_access_tokens_table', 3),
	(36, '2025_09_14_201745_alter_abonos_add_tipo_minutos', 3),
	(37, '2025_09_16_114749_create_afastamentos_table', 3),
	(38, '2025_09_18_215238_create_personal_access_tokens_table', 3),
	(39, 'create_horarios_table', 3),
	(40, 'xxxx_xx_xx_create_abonos_table', 3);

-- Copiando estrutura para tabela ponto_empresa.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.password_reset_tokens: ~0 rows (aproximadamente)
DELETE FROM `password_reset_tokens`;

-- Copiando estrutura para tabela ponto_empresa.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.personal_access_tokens: ~13 rows (aproximadamente)
DELETE FROM `personal_access_tokens`;
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\Usuario', 2, 'token-pwa', 'f713774568f35f0dbe9466662bef056123534f1d4153cde19b7532a25eec2ac2', '["*"]', NULL, NULL, '2025-09-17 15:26:27', '2025-09-17 15:26:27'),
	(2, 'App\\Models\\Usuario', 2, 'auth_token', '4ae61a08003d3a995d175a71de14ad16f3ed6004292305c85029b4d346e02210', '["*"]', NULL, NULL, '2025-09-17 22:04:38', '2025-09-17 22:04:38'),
	(3, 'App\\Models\\Usuario', 2, 'auth_token', 'c6de3214bec4de10f2324d930d81a7b541ecab432a0495e77d500c4ecf0a83bd', '["*"]', NULL, NULL, '2025-09-17 22:04:50', '2025-09-17 22:04:50'),
	(4, 'App\\Models\\Usuario', 2, 'auth_token', '5f21771124cbb10303e6cd6a4a7ee483c5cc5777c83b68817ba8d5718e315edc', '["*"]', NULL, NULL, '2025-09-17 22:14:42', '2025-09-17 22:14:42'),
	(5, 'App\\Models\\Usuario', 2, 'auth_token', 'dd19953910074e1ffa387b5c8cc3e46e12fb82535e0995776d23e275c2cddefb', '["*"]', NULL, NULL, '2025-09-17 22:15:33', '2025-09-17 22:15:33'),
	(6, 'App\\Models\\Usuario', 2, 'auth_token', '4d7548636cd298321db3a240180d00727c060583d3b7f70fa0146be5509143e7', '["*"]', NULL, NULL, '2025-09-17 22:25:50', '2025-09-17 22:25:50'),
	(7, 'App\\Models\\Usuario', 2, 'auth_token', '5232873ae1e5c67a4f00699c6caa0e82afb191df56db1453afefcfd7c6f337d3', '["*"]', NULL, NULL, '2025-09-17 22:28:39', '2025-09-17 22:28:39'),
	(8, 'App\\Models\\Usuario', 2, 'auth_token', '8d53416dc8a5fead3523d0324ea2e164e27d64877e2df0cc34fb00b6db956fd3', '["*"]', NULL, NULL, '2025-09-17 22:31:50', '2025-09-17 22:31:50'),
	(9, 'App\\Models\\Usuario', 2, 'auth_token', '27626453e6554835a977a7493d42852a596ff1713b12092b5ce6e032eb1fe286', '["*"]', '2025-09-17 22:38:05', NULL, '2025-09-17 22:36:36', '2025-09-17 22:38:05'),
	(10, 'App\\Models\\Usuario', 2, 'auth_token', '0a6df81bf3d90379a63e12fafb25285193511a3ab95944875b45c5adff0ba4c9', '["*"]', '2025-09-19 00:29:57', NULL, '2025-09-17 22:53:15', '2025-09-19 00:29:57'),
	(11, 'App\\Models\\User', 1, 'pwa-token', '21914d7fd54d002c46d10c526c7c65d9f10f4342fcf262bdf9cabbef92ec2c69', '["*"]', NULL, NULL, '2025-09-18 23:31:35', '2025-09-18 23:31:35'),
	(12, 'App\\Models\\User', 2, 'token', 'd0bfd790cf66743632b83b1c09e68ba4b2b2628dce47237d4ddc73d3c62c929a', '["*"]', NULL, NULL, '2025-09-19 01:11:27', '2025-09-19 01:11:27'),
	(13, 'App\\Models\\User', 2, 'token', 'fceaf674d0a4db43566554cb21724479ea32113a6b6f375b1cc9cc5ee8b565ed', '["*"]', NULL, NULL, '2025-09-19 01:53:50', '2025-09-19 01:53:50');

-- Copiando estrutura para tabela ponto_empresa.pontos
CREATE TABLE IF NOT EXISTS `pontos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `batido_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` varchar(255) NOT NULL DEFAULT 'entrada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pontos_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `pontos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.pontos: ~12 rows (aproximadamente)
DELETE FROM `pontos`;
INSERT INTO `pontos` (`id`, `usuario_id`, `batido_em`, `tipo`, `created_at`, `updated_at`) VALUES
	(1, 2, '2025-09-17 12:58:26', 'entrada', '2025-09-17 15:58:26', '2025-09-17 15:58:26'),
	(2, 2, '2025-09-17 12:58:34', 'entrada', '2025-09-17 15:58:34', '2025-09-17 15:58:34'),
	(3, 2, '2025-09-17 12:59:30', 'entrada', '2025-09-17 15:59:30', '2025-09-17 15:59:30'),
	(4, 2, '2025-09-17 13:05:13', 'entrada', '2025-09-17 16:05:13', '2025-09-17 16:05:13'),
	(5, 2, '2025-09-17 13:11:53', 'entrada', '2025-09-17 16:11:53', '2025-09-17 16:11:53'),
	(6, 2, '2025-09-17 13:14:38', 'entrada', '2025-09-17 16:14:38', '2025-09-17 16:14:38'),
	(7, 2, '2025-09-17 13:17:36', 'entrada', '2025-09-17 16:17:36', '2025-09-17 16:17:36'),
	(8, 2, '2025-09-17 13:23:56', 'entrada', '2025-09-17 16:23:56', '2025-09-17 16:23:56'),
	(9, 2, '2025-09-17 13:24:35', 'entrada', '2025-09-17 16:24:35', '2025-09-17 16:24:35'),
	(10, 2, '2025-09-17 16:55:04', 'saída', '2025-09-17 16:55:04', '2025-09-17 16:55:04'),
	(11, 2, '2025-09-17 17:12:29', 'entrada', '2025-09-17 17:12:29', '2025-09-17 17:12:29'),
	(12, 2, '2025-09-17 17:12:33', 'saída', '2025-09-17 17:12:33', '2025-09-17 17:12:33');

-- Copiando estrutura para tabela ponto_empresa.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.sessions: ~5 rows (aproximadamente)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('5RL24WsOT2BOwe77rcqwEoIWeUfrJPlq9hzCUazE', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:142.0) Gecko/20100101 Firefox/142.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiejA4MUhqSlJkdm1qQVJ0UktKdUg4Tmh0OHVqMkhOTThHT0hBRWtxWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1758247038),
	('7lmnQZRuKxiDZF5GZUYQ5PhxINTLkG1mULuiz7cn', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoienpQbFRFOUROcEFoY0dMMDBlalJHR2dtdllyYmZ6eFhreDMxMWNWcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZmFzdGFtZW50b3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1758247421),
	('hSMmmcdwNyiuxL00pViM8C0gYhaisV1yTv8ejnHF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:142.0) Gecko/20100101 Firefox/142.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmg2MVRmWDlrdTgwZkdhd3hNTTFZUUVid3JVTnJuZWNkTTdFdXBhNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758247400),
	('tle89mVGshwKB63flzrjzI3EFXxtfiS6JeI9Svnx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:142.0) Gecko/20100101 Firefox/142.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid0FuM1BMTHJrS0VxaU1NZHNCVFFUQzZ2OHpzcGJEeURlRGN0MVJ4YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758242419),
	('UqPvZaY2x9tZOPIbAbnOS13jeiGM66bmPjwAKFVB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:142.0) Gecko/20100101 Firefox/142.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUm5DcDBpdGhOQko3Q2cydEtoNk1OVXpPdW40NUJMd2xud25jdURCdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758246767);

-- Copiando estrutura para tabela ponto_empresa.tokens_qr
CREATE TABLE IF NOT EXISTS `tokens_qr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(10) NOT NULL,
  `status` enum('ativo','usado') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `usado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.tokens_qr: ~100 rows (aproximadamente)
DELETE FROM `tokens_qr`;
INSERT INTO `tokens_qr` (`id`, `token`, `status`, `criado_em`, `usado_em`) VALUES
	(1, 'ST0-2BU', 'ativo', '2025-09-18 21:45:02', NULL),
	(2, '9JD-3IF', 'ativo', '2025-09-18 21:45:02', NULL),
	(3, 'TE6-G2G', 'ativo', '2025-09-18 21:45:02', NULL),
	(4, '8BR-G4P', 'usado', '2025-09-18 21:45:02', '2025-09-18 23:40:42'),
	(5, 'S8J-5QR', 'ativo', '2025-09-18 21:45:02', NULL),
	(6, 'I4D-W3Q', 'ativo', '2025-09-18 21:45:02', NULL),
	(7, '91A-HHE', 'ativo', '2025-09-18 21:45:02', NULL),
	(8, '0JX-QL8', 'ativo', '2025-09-18 21:45:02', NULL),
	(9, '0ZD-MG9', 'ativo', '2025-09-18 21:45:02', NULL),
	(10, 'PE1-B1W', 'ativo', '2025-09-18 21:45:02', NULL),
	(11, '0YJ-A3G', 'ativo', '2025-09-18 21:45:02', NULL),
	(12, 'WD2-0CF', 'ativo', '2025-09-18 21:45:02', NULL),
	(13, 'NA1-VJ2', 'ativo', '2025-09-18 21:45:02', NULL),
	(14, 'X9V-GZ4', 'ativo', '2025-09-18 21:45:02', NULL),
	(15, 'M4V-2DJ', 'ativo', '2025-09-18 21:45:02', NULL),
	(16, '0HT-NT0', 'ativo', '2025-09-18 21:45:02', NULL),
	(17, 'YM0-1VE', 'ativo', '2025-09-18 21:45:02', NULL),
	(18, 'T7M-BH4', 'ativo', '2025-09-18 21:45:02', NULL),
	(19, 'NE2-W4F', 'ativo', '2025-09-18 21:45:02', NULL),
	(20, 'HE9-UB3', 'ativo', '2025-09-18 21:45:02', NULL),
	(21, 'H63-JFA', 'ativo', '2025-09-18 21:45:02', NULL),
	(22, 'OH2-4FK', 'ativo', '2025-09-18 21:45:02', NULL),
	(23, 'SW1-DC7', 'ativo', '2025-09-18 21:45:02', NULL),
	(24, '67T-VOS', 'ativo', '2025-09-18 21:45:02', NULL),
	(25, '1N2-POE', 'ativo', '2025-09-18 21:45:02', NULL),
	(26, 'P2B-W4E', 'ativo', '2025-09-18 21:45:02', NULL),
	(27, 'HT6-JC7', 'ativo', '2025-09-18 21:45:02', NULL),
	(28, 'CM8-Z5J', 'ativo', '2025-09-18 21:45:02', NULL),
	(29, 'H9S-S3Q', 'ativo', '2025-09-18 21:45:02', NULL),
	(30, 'KZ8-9CK', 'ativo', '2025-09-18 21:45:02', NULL),
	(31, 'R1P-9FA', 'ativo', '2025-09-18 21:45:02', NULL),
	(32, 'ZQH-54G', 'ativo', '2025-09-18 21:45:02', NULL),
	(33, '1PC-2OK', 'ativo', '2025-09-18 21:45:02', NULL),
	(34, '6PV-S7Q', 'ativo', '2025-09-18 21:45:02', NULL),
	(35, 'X5D-9JO', 'ativo', '2025-09-18 21:45:02', NULL),
	(36, '3GE-ZE6', 'ativo', '2025-09-18 21:45:02', NULL),
	(37, '2SV-EV0', 'ativo', '2025-09-18 21:45:02', NULL),
	(38, 'L1E-ZP2', 'ativo', '2025-09-18 21:45:02', NULL),
	(39, 'GZ2-L4D', 'ativo', '2025-09-18 21:45:02', NULL),
	(40, 'KT8-XV3', 'ativo', '2025-09-18 21:45:02', NULL),
	(41, '0K0-UKE', 'ativo', '2025-09-18 21:45:02', NULL),
	(42, 'PYE-U91', 'ativo', '2025-09-18 21:45:02', NULL),
	(43, 'ZHA-18C', 'ativo', '2025-09-18 21:45:02', NULL),
	(44, 'VO4-7FB', 'ativo', '2025-09-18 21:45:02', NULL),
	(45, 'L6Z-G0O', 'ativo', '2025-09-18 21:45:02', NULL),
	(46, 'GGC-E88', 'ativo', '2025-09-18 21:45:02', NULL),
	(47, '8G2-PKW', 'ativo', '2025-09-18 21:45:02', NULL),
	(48, 'LF9-7MR', 'ativo', '2025-09-18 21:45:02', NULL),
	(49, 'E3Y-N6J', 'ativo', '2025-09-18 21:45:02', NULL),
	(50, '9TV-1DI', 'ativo', '2025-09-18 21:45:02', NULL),
	(51, '0KC-1AK', 'ativo', '2025-09-18 21:45:02', NULL),
	(52, 'U8G-H3X', 'ativo', '2025-09-18 21:45:02', NULL),
	(53, 'K6D-ZT2', 'ativo', '2025-09-18 21:45:02', NULL),
	(54, '3XL-1HO', 'ativo', '2025-09-18 21:45:02', NULL),
	(55, 'LL0-6ST', 'ativo', '2025-09-18 21:45:02', NULL),
	(56, '7GN-5TS', 'ativo', '2025-09-18 21:45:02', NULL),
	(57, '9KP-8ES', 'ativo', '2025-09-18 21:45:02', NULL),
	(58, 'Y0X-9UA', 'ativo', '2025-09-18 21:45:02', NULL),
	(59, 'V85-CPU', 'ativo', '2025-09-18 21:45:02', NULL),
	(60, 'WJD-S87', 'ativo', '2025-09-18 21:45:02', NULL),
	(61, 'U6B-FV7', 'ativo', '2025-09-18 21:45:02', NULL),
	(62, 'XJF-78C', 'ativo', '2025-09-18 21:45:02', NULL),
	(63, 'D6O-YF3', 'ativo', '2025-09-18 21:45:02', NULL),
	(64, 'VWV-6I8', 'ativo', '2025-09-18 21:45:02', NULL),
	(65, 'NJ8-LZ1', 'ativo', '2025-09-18 21:45:02', NULL),
	(66, 'GYQ-06K', 'ativo', '2025-09-18 21:45:02', NULL),
	(67, '2X7-BOH', 'ativo', '2025-09-18 21:45:02', NULL),
	(68, 'E23-MAU', 'ativo', '2025-09-18 21:45:02', NULL),
	(69, '26X-YGM', 'ativo', '2025-09-18 21:45:02', NULL),
	(70, 'IP5-Y0T', 'ativo', '2025-09-18 21:45:02', NULL),
	(71, '3GG-4MO', 'ativo', '2025-09-18 21:45:02', NULL),
	(72, 'DLL-2E8', 'ativo', '2025-09-18 21:45:02', NULL),
	(73, '3DV-G8Z', 'ativo', '2025-09-18 21:45:02', NULL),
	(74, '5VS-CM4', 'ativo', '2025-09-18 21:45:02', NULL),
	(75, 'SL0-SC2', 'ativo', '2025-09-18 21:45:02', NULL),
	(76, 'G0Z-3JG', 'ativo', '2025-09-18 21:45:02', NULL),
	(77, 'C4R-L9M', 'ativo', '2025-09-18 21:45:02', NULL),
	(78, '00D-CZN', 'ativo', '2025-09-18 21:45:02', NULL),
	(79, 'Y29-KOG', 'ativo', '2025-09-18 21:45:02', NULL),
	(80, 'PLO-4S5', 'ativo', '2025-09-18 21:45:02', NULL),
	(81, '1H2-QEZ', 'ativo', '2025-09-18 21:45:02', NULL),
	(82, 'JCF-F86', 'ativo', '2025-09-18 21:45:02', NULL),
	(83, 'LLU-7Z7', 'ativo', '2025-09-18 21:45:02', NULL),
	(84, '5WK-9OM', 'ativo', '2025-09-18 21:45:02', NULL),
	(85, '66N-LZR', 'ativo', '2025-09-18 21:45:02', NULL),
	(86, 'GQP-48W', 'ativo', '2025-09-18 21:45:02', NULL),
	(87, 'FO2-7WC', 'ativo', '2025-09-18 21:45:02', NULL),
	(88, 'FX1-4WN', 'ativo', '2025-09-18 21:45:02', NULL),
	(89, '1JB-AB4', 'ativo', '2025-09-18 21:45:02', NULL),
	(90, 'NAG-1M5', 'ativo', '2025-09-18 21:45:02', NULL),
	(91, 'QY2-FJ6', 'ativo', '2025-09-18 21:45:02', NULL),
	(92, 'IDV-S53', 'ativo', '2025-09-18 21:45:02', NULL),
	(93, 'DOF-15S', 'ativo', '2025-09-18 21:45:02', NULL),
	(94, 'G3X-J7P', 'ativo', '2025-09-18 21:45:02', NULL),
	(95, 'H0H-GW9', 'ativo', '2025-09-18 21:45:02', NULL),
	(96, 'SBY-2H9', 'ativo', '2025-09-18 21:45:02', NULL),
	(97, '0XK-E1J', 'ativo', '2025-09-18 21:45:02', NULL),
	(98, 'L58-TKD', 'ativo', '2025-09-18 21:45:02', NULL),
	(99, 'F13-HGW', 'ativo', '2025-09-18 21:45:02', NULL),
	(100, 'AE2-C1P', 'ativo', '2025-09-18 21:45:02', NULL);

-- Copiando estrutura para tabela ponto_empresa.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela ponto_empresa.users: ~4 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Test User', 'test@example.com', '2025-09-16 15:30:44', '$2y$12$s3bPLYTbcYaQ0JURlkQmF.PFJ7dVe/gJQAQxO32vxkWmUjsWm/OoS', 'qhAKvGK5YW', '2025-09-16 15:30:45', '2025-09-16 15:30:45'),
	(2, 'Bruno', 'bruno@teste.com', NULL, '$2y$12$cFF7k/lWrqeNvpWmdSnwrOpz.amel1Dy7t4.uVwpgNnofbq5kMvPS', NULL, '2025-09-19 01:10:32', '2025-09-19 01:10:32'),
	(3, 'Administrador', 'admin@teste.com', NULL, '$2y$12$tBE7vdP69hGtX2QD7fGnLeAQO2xRnLfd3lVVbDJfompd8wR2tBEsm', NULL, '2025-09-19 01:16:53', '2025-09-19 01:16:53'),
	(5, 'Bruno D Moraes', 'brunodmoraes@gmail.com', NULL, '$2y$12$X2bBRvjnaRp7.r0n16pg7eEbOU3ySxmyEKYwYe4HyRm3X3ksp.IBG', NULL, '2025-09-19 01:57:09', '2025-09-19 01:57:09');

-- Copiando estrutura para tabela ponto_empresa.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `cargo` varchar(80) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ponto_empresa.usuarios: ~27 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `nome`, `email`, `password`, `cpf`, `cargo`, `ativo`, `criado_em`) VALUES
	(1, 'Bruno', 'Páscoa', NULL, '03726241388', 'Digitador', 1, '2025-09-13 13:19:14'),
	(2, 'maria', 'ma@gmail.com', '$2y$12$Xyw/f31ZKuKLprOPFfDKB.7qx0hgI3C/X3RR1QOtoObnaDj4hC87G', '12345645454', 'RH', 1, '2025-09-13 13:26:55'),
	(3, 'Antonio Silva Souza', 'saa@gma.com', NULL, '211345646', 'Delegado', 1, '2025-09-13 14:26:50'),
	(4, 'Maria Silva', 'maria.silva@empresa.com', NULL, '123.456.789-00', 'Analista de RH', 1, '2025-09-13 15:16:07'),
	(5, 'João Souza', 'joao.souza@empresa.com', NULL, '987.654.321-00', 'Desenvolvedor', 1, '2025-09-13 15:16:07'),
	(6, 'Ana Costa', 'ana.costa@empresa.com', NULL, '111.222.333-44', 'Gerente de Projetos', 1, '2025-09-13 15:16:07'),
	(7, 'Carlos Pereira', 'carlos@empresa.com', NULL, '222.333.444-55', 'Estagiário', 1, '2025-09-13 15:46:04'),
	(8, 'Leon Herman II', 'kunde.kristin@example.net', NULL, '65035573467', 'Infantry Officer', 1, '2025-09-16 12:36:48'),
	(9, 'Laurence McDermott', 'salvador.nolan@example.com', NULL, '53741664994', 'Supervisor of Police', 1, '2025-09-16 12:36:48'),
	(10, 'Bethel Kulas IV', 'jess.hamill@example.org', NULL, '29209116864', 'Precision Pattern and Die Caster', 1, '2025-09-16 12:36:48'),
	(11, 'Prof. Zoie Cremin', 'violet83@example.org', NULL, '62185902452', 'Nuclear Technician', 1, '2025-09-16 12:36:48'),
	(12, 'Prof. Elias Wolff DDS', 'sibyl.bradtke@example.com', NULL, '93658475327', 'Electrician', 1, '2025-09-16 12:36:48'),
	(13, 'Gilberto Hoeger', 'mose72@example.com', NULL, '08956424299', 'Chemical Engineer', 1, '2025-09-16 12:36:48'),
	(14, 'Kieran Johnston', 'ecole@example.com', NULL, '29328080219', 'Pharmaceutical Sales Representative', 1, '2025-09-16 12:36:48'),
	(15, 'Araceli Rau', 'declan90@example.net', NULL, '29219079290', 'Welder', 1, '2025-09-16 12:36:48'),
	(16, 'Annette Ward Jr.', 'frank12@example.net', NULL, '68498636294', 'Annealing Machine Operator', 1, '2025-09-16 12:36:48'),
	(17, 'Dillan Sporer', 'nicholas.schamberger@example.com', NULL, '45154187078', 'Life Scientists', 1, '2025-09-16 12:36:48'),
	(18, 'Gerry Monahan', 'towne.skyla@example.com', NULL, '97920200063', 'Respiratory Therapist', 1, '2025-09-16 12:36:48'),
	(19, 'Prof. Devin Schmitt', 'anderson.labadie@example.com', NULL, '22648471670', 'Plastic Molding Machine Operator', 1, '2025-09-16 12:36:48'),
	(20, 'Jalyn Reilly', 'asawayn@example.net', NULL, '98261253836', 'Petroleum Engineer', 1, '2025-09-16 12:36:48'),
	(21, 'Elta Konopelski', 'pwiza@example.com', NULL, '36004631144', 'Dispatcher', 1, '2025-09-16 12:36:48'),
	(22, 'Dr. Enrique Armstrong Jr.', 'caleigh.bailey@example.com', NULL, '09813862912', 'Bicycle Repairer', 1, '2025-09-16 12:36:48'),
	(23, 'Darron Mills', 'arielle.herman@example.net', NULL, '54775357943', 'Data Processing Equipment Repairer', 1, '2025-09-16 12:36:48'),
	(24, 'Jace Bahringer', 'troy.beatty@example.org', NULL, '71069290701', 'Hand Sewer', 1, '2025-09-16 12:36:48'),
	(25, 'Kaylee Hessel', 'imogene.harvey@example.net', NULL, '50795324918', 'Electrical Power-Line Installer', 1, '2025-09-16 12:36:48'),
	(26, 'Madeline Reichert', 'ardith.ziemann@example.net', NULL, '03087831725', 'HVAC Mechanic', 1, '2025-09-16 12:36:48'),
	(27, 'Natalie Block', 'vpowlowski@example.org', NULL, '32938918325', 'Stationary Engineer', 1, '2025-09-16 12:36:48');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

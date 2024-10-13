-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 14 sep. 2024 à 13:56
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `arcadia_zoo`
--

-- --------------------------------------------------------

--
-- Structure de la table `animals`
--

CREATE TABLE `animals` (
  `id_animal` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `breed` int(11) NOT NULL,
  `housing` int(11) NOT NULL,
  `isVisible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id_animal`, `name`, `breed`, `housing`, `isVisible`) VALUES
(1, 'Shiva', 3, 1, 0),
(2, 'Marcel', 1, 1, 1),
(4, 'Dumbo', 4, 2, 1),
(5, 'Prince Edward', 5, 2, 1),
(6, 'Rocky', 6, 2, 1),
(7, 'Lacoste', 7, 3, 1),
(8, 'Nez-rond', 8, 3, 1),
(9, 'Shakira', 9, 3, 1),
(10, 'Cléopatre', 2, 1, 1),
(11, 'Gloria', 10, 2, 1),
(14, 'Rivers', 15, 2, 1),
(15, 'Gigi l amoro', 16, 2, 1),
(16, 'Bob', 17, 2, 1),
(17, 'Miro', 18, 2, 1),
(18, 'Marty', 19, 2, 1),
(19, 'Moufassa', 5, 2, 1),
(20, 'Simba', 5, 2, 1),
(21, 'Pretty boy', 20, 1, 1),
(22, 'Roi Louie', 13, 1, 1),
(23, 'Serge', 14, 1, 1),
(24, 'Faloo', 21, 1, 1),
(25, 'Red', 21, 1, 1),
(27, 'Roger', 22, 3, 1),
(28, 'Socute', 23, 1, 1),
(30, 'Jacko 1er', 24, 4, 1),
(39, 'lucy', 8, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `breeds`
--

CREATE TABLE `breeds` (
  `id_breed` int(11) NOT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `breeds`
--

INSERT INTO `breeds` (`id_breed`, `label`) VALUES
(1, 'Ouistiti (singe)'),
(2, 'Léopard'),
(3, 'Tigre'),
(4, 'Eléphant'),
(5, 'Lion'),
(6, 'Rhinocéros'),
(7, 'Crocodile'),
(8, 'Alligator'),
(9, 'Serpent Ratier-Rhinocéros'),
(10, 'Hippopotame'),
(13, 'Orang-outan (singe)'),
(14, 'Macaque (singe)'),
(15, 'Dik-dik'),
(16, 'Girafe'),
(17, 'Lycaon'),
(18, 'Lynx tacheté'),
(19, 'Zèbre'),
(20, 'Koala'),
(21, 'Kangourou'),
(22, 'Pélican'),
(23, 'Ouistiti pygmé (singe)'),
(24, 'Cigogne noire'),
(25, 'Aigle royale');

-- --------------------------------------------------------

--
-- Structure de la table `comments_housing_veto`
--

CREATE TABLE `comments_housing_veto` (
  `id_comment` int(11) NOT NULL,
  `veterinarian` varchar(255) NOT NULL,
  `housing` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `archive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments_housing_veto`
--

INSERT INTO `comments_housing_veto` (`id_comment`, `veterinarian`, `housing`, `comment`, `date`, `archive`) VALUES
(1, 'veto@arcadia.com', 2, 'L\'enclos de Dumbo a besoin d\'un bon nettoyage!', '2024-08-07', 0),
(9, 'aGator@arcadia.com', 3, 'Des algues toxics sont en train de proliférer dans l\'étang secondaire. Un traitement de l\'eau est nécessaire.', '2024-08-08', 0),
(11, 'veto@arcadia.com', 1, 'Les singes ont réussi à faire un trou dans la cloture (vers le plus grand baobab). Il faut la réparer', '2024-08-08', 0),
(12, 'aGator@arcadia.com', 2, 'Les lions se sont battus il y a du sang partout... ', '2024-08-09', 0),
(13, 'aGator@arcadia.com', 4, 'Il existe un nid dans l\'arbre qui devait être abattu. Il est nécessaire de reporter...', '2024-08-28', 0),
(15, 'aGator@arcadia.com', 2, 'iwnhwkg!!', '2024-09-07', 0);

-- --------------------------------------------------------

--
-- Structure de la table `fed_animals`
--

CREATE TABLE `fed_animals` (
  `id_fed` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `hour` time NOT NULL DEFAULT current_timestamp(),
  `animal` int(11) NOT NULL,
  `employee` varchar(255) NOT NULL,
  `food` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fed_animals`
--

INSERT INTO `fed_animals` (`id_fed`, `date`, `hour`, `animal`, `employee`, `food`, `weight`) VALUES
(2, '2024-08-13', '08:30:17', 28, 'bidon@arcadia.com', 'fraises', '100g'),
(3, '2024-08-14', '08:30:00', 20, 'bidon@arcadia.com', 'Antilope', '50kg'),
(5, '2024-08-13', '09:30:00', 20, 'bidon@arcadia.com', 'gazelle', '50kg'),
(6, '2024-08-14', '14:49:00', 1, 'bidon@arcadia.com', 'beuf', '20kg'),
(7, '2024-09-04', '18:26:00', 17, 'bidon@arcadia.com', 'Biche', '10kg'),
(8, '2024-09-07', '18:00:00', 4, 'bidon@arcadia.com', 'Chou', '10kg'),
(9, '2024-09-07', '18:11:00', 27, 'bidon@arcadia.com', 'Merlu', '2kg'),
(10, '2024-09-07', '18:13:00', 23, 'bidon@arcadia.com', 'Bananes', '1kg'),
(11, '2024-09-07', '18:18:00', 22, 'bidon@arcadia.com', 'Salade', '5kg');

-- --------------------------------------------------------

--
-- Structure de la table `housings`
--

CREATE TABLE `housings` (
  `id_housing` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `housings`
--

INSERT INTO `housings` (`id_housing`, `name`, `description`) VALUES
(1, 'La jungle', 'forêt tropicale, à la végétation épaisse et luxuriante, dont l\'une des principales caractéristiques est sa canopée dense aux arbres hauts, créant un couvert végétal presque impénétrable.'),
(2, 'La savane', 'Plongez au cœur d\'une savane majestueuse où lions, éléphants et girafes règnent en maîtres. Découvrez un monde sauvage, rempli de rencontres inoubliables et d\'aventures à couper le souffle. Vivez la magie de la nature à chaque pas !'),
(3, 'Le marais', 'zone humide avec des eaux stagnantes où s\'accumulent des sédiments sur une faible épaisseur.'),
(4, 'La volière', 'Vous pourrez y retrouver aussi bien des oiseaux de petites tailles que des grands. Le dôme offre bien plus qu’un simple espace de vol. C’est un lieu de vie et d’échange dans lequel vous pouvez observer la faune en toute liberté.');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id_image` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `icon` tinyint(1) NOT NULL DEFAULT 0,
  `portrait` tinyint(1) NOT NULL DEFAULT 0,
  `attribution` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id_image`, `path`, `description`, `icon`, `portrait`, `attribution`) VALUES
(2, 'View/assets/img/housings/1/2.jpg', 'Trois singes jouant dans un arbre', 0, 0, ''),
(3, 'View/assets/img/housings/2/3.jpg', 'Pleins de girafes gambadants', 0, 0, ''),
(4, 'View/assets/img/housings/3/4.jpg', 'Une petite fille admirant un aquarium de pirhannas', 0, 0, ''),
(5, 'View/assets/img/animals/2-Marcel/Marcel1.jpg', 'Le bébé chimpanzé Marcel tout mignon dans un arbre', 0, 0, ''),
(6, 'View/assets/img/animals/10-Cléopatre/Cléopatre1.jpg', 'Cléopatre la léoparde regardant devant elle', 0, 0, ''),
(7, 'View/assets/img/animals/1-Shiva/Shiva1.jpg', 'Le tigre Shiva, marchant fièrement regardant devant soit.', 0, 0, ''),
(8, 'View/assets/img/animals/4-Dumbo/Dumbo1.jpg', 'La tête de Dumbo l\'éléphant recouverte de terre avec la trompe en l\'air.', 0, 0, ''),
(9, 'View/assets/img/animals/5-Prince Edward/Prince Edward1.jpg', 'Le lion prince Edward fièrement avachi par terre.', 0, 0, ''),
(10, 'View/assets/img/animals/6-Rocky/Rocky1.jpg', 'La tête de Rocky le rhinocéros marchant dans l\'herbe.', 0, 1, ''),
(11, 'View/assets/img/animals/7-Lacoste/Lacoste1.jpg', 'Lacoste, crocodile, sortant de l\'eau et levant bien haut la tête.', 0, 0, ''),
(12, 'View/assets/img/animals/8-Nez-rond/Nez-rond1.jpg', 'Tête de Nez-rond l\'aligator, sautant de l\'eau.', 0, 0, ''),
(13, 'View/assets/img/animals/9-Shakira/Shakira1.jpg', 'Shakira, serpant à la couleur vert flashy, enroulée autour d\'une branche.', 0, 0, ''),
(14, 'View/assets/img/animals/11-Gloria/Gloria1.jpg', 'La tête de Gloria, l\'hyppopotame sortant de l\'eau.', 0, 0, ''),
(15, 'View/assets/img/animals/11-Gloria/Gloria2.jpg', 'Gloria, l\'hyppopotame, prend la pose dans l\'eau.', 0, 0, ''),
(16, 'View/assets/img/animals/6-Rocky/Rocky2.jpg', 'Tête du rhinocéros Rocky pris de coté.', 0, 0, ''),
(35, 'View/assets/img/services/41/icon.png', 'NULL', 1, 0, '<a href=\"https://www.flaticon.com/fr/icones-gratuites/guide-touristique\" title=\"guide touristique icônes\">Guide touristique icônes créées par Freepik – Flaticon</a>'),
(36, 'View/assets/img/services/41/photo1.jpg', 'Employé du zoo tenant un bébé caïman.', 0, 1, ''),
(41, 'View/assets/img/services/44/icon.png', 'Null', 1, 0, '<a href=\"https://www.flaticon.com/fr/icones-gratuites/nourriture\" title=\"nourriture icônes\">Nourriture icônes créées par Freepik – Flaticon</a>'),
(42, 'View/assets/img/services/44/photo1.jpg', 'Chef déposant délicatement sur un tronc des mets', 0, 0, ''),
(65, 'View/assets/img/services/56/icon.png', 'Null', 1, 0, '<a href=\"https://www.flaticon.com/fr/icones-gratuites/train-jouet\" title=\"train jouet icônes\">Train jouet icônes créées par Peter Lakenbrink - Flaticon</a>'),
(66, 'View/assets/img/services/56/photo1.jpg', 'Nos deux petits trains (orange et bleu).', 0, 0, ''),
(82, 'View/assets/img/services/66/icon.png', 'Null', 1, 0, '<a href=\"https://www.flaticon.com/fr/icones-gratuites/veterinaire\" title=\"vétérinaire icônes\">Vétérinaire icônes créées par Freepik - Flaticon</a>'),
(83, 'View/assets/img/services/66/photo1.jpg', 'Soigneur jouant avec des petits singes', 0, 1, ''),
(84, 'View/assets/img/animals/2-Marcel/Marcel2.jpg', 'Marcel, petit chimpanzé, se cache dans un arbre', 0, 0, ''),
(91, 'View/assets/img/animals/1-Shiva/Shiva-1722256004.jpg', 'NULL', 0, 0, ''),
(93, 'View/assets/img/animals/1-Shiva/Shiva-1722256204.jpg', 'NULL', 0, 0, ''),
(157, 'View/assets/img/housings/1/1.jpg', 'Tigre s\'abreuvant', 0, 0, ''),
(158, 'View/assets/img/housings/3/5.jpg', 'La cabane d\'observation perdu dans le marais.', 0, 0, ''),
(160, 'View/assets/img/animals/27-Roger/Roger-1723450892.jpg', 'NULL', 0, 0, ''),
(162, 'View/assets/img/animals/28-Socute/Socute-1723452852.jpg', 'NULL', 0, 0, ''),
(163, 'View/assets/img/housings/6/Désert-1723455711.png', 'NULL', 0, 0, ''),
(167, 'View/assets/img/housings/4/La volière-1723469851.jpg', 'NULL', 0, 0, ''),
(168, 'View/assets/img/housings/4/La volière-1723470108.jpg', 'NULL', 0, 0, ''),
(170, 'View/assets/img/animals/20-Simba/Simba-1723625278.jpg', 'NULL', 0, 0, ''),
(171, 'View/assets/img/animals/30-jacko 1er/jacko 1er-1724831830.jpg', 'NULL', 0, 0, ''),
(172, 'View/assets/img/animals/25-Red/Red-1724847450.jpg', 'NULL', 0, 0, ''),
(173, 'View/assets/img/animals/23-Serge/Serge-1724946375.jpg', 'NULL', 0, 0, ''),
(174, 'View/assets/img/animals/22-Roi Louie/Roi Louie-1724946437.jpg', 'NULL', 0, 0, ''),
(175, 'View/assets/img/animals/21-Pretty boy/Pretty boy-1724946501.jpg', 'NULL', 0, 1, ''),
(176, 'View/assets/img/animals/14-Rivers/Rivers-1724946587.jpg', 'NULL', 0, 0, ''),
(177, 'View/assets/img/animals/18-Marty/Marty-1724946633.jpg', 'NULL', 0, 0, ''),
(178, 'View/assets/img/animals/16-Bob/Bob-1724946742.jpg', 'NULL', 0, 0, ''),
(179, 'View/assets/img/animals/15-Gigi l amoro/Gigi l amoro-1724946861.jpg', 'NULL', 0, 0, ''),
(180, 'View/assets/img/animals/17-Miro/Miro-1724946937.jpg', 'NULL', 0, 0, ''),
(181, 'View/assets/img/services/67/icon.png', '', 1, 0, '                            <a href=\"https://www.flaticon.com/fr/icones-gratuites/veterinaire\" title=\"vétérinaire icônes\">Vétérinaire icônes créées par Freepik - Flaticon</a>                        '),
(182, 'View/assets/img/services/67/photo1.jpg', '', 0, 1, '                                                                                                                                                                                                                                                                                                            '),
(187, 'View/assets/img/animals/19-Moufassa/Moufassa-1725715405.jpg', 'NULL', 0, 0, ''),
(194, 'View/assets/img/animals/39-lucy/lucy-1725717369.jpg', 'NULL', 0, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `images_animals`
--

CREATE TABLE `images_animals` (
  `id_animal` int(11) NOT NULL,
  `id_image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_animals`
--

INSERT INTO `images_animals` (`id_animal`, `id_image`) VALUES
(1, 7),
(1, 91),
(1, 93),
(2, 5),
(2, 84),
(4, 8),
(5, 9),
(6, 10),
(6, 16),
(7, 11),
(8, 12),
(9, 13),
(10, 6),
(11, 14),
(11, 15),
(14, 176),
(15, 179),
(16, 178),
(17, 180),
(18, 177),
(19, 187),
(20, 170),
(21, 175),
(22, 174),
(23, 173),
(25, 172),
(27, 160),
(28, 162),
(30, 171),
(39, 194);

-- --------------------------------------------------------

--
-- Structure de la table `images_housings`
--

CREATE TABLE `images_housings` (
  `id_housing` int(11) NOT NULL,
  `id_image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_housings`
--

INSERT INTO `images_housings` (`id_housing`, `id_image`) VALUES
(1, 2),
(1, 157),
(2, 3),
(3, 4),
(3, 158),
(4, 167),
(4, 168);

-- --------------------------------------------------------

--
-- Structure de la table `images_services`
--

CREATE TABLE `images_services` (
  `id_service` int(11) NOT NULL,
  `id_image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_services`
--

INSERT INTO `images_services` (`id_service`, `id_image`) VALUES
(41, 35),
(41, 36),
(44, 41),
(44, 42),
(56, 65),
(56, 66),
(67, 181),
(67, 182);

-- --------------------------------------------------------

--
-- Structure de la table `reports_veterinarian`
--

CREATE TABLE `reports_veterinarian` (
  `id_report` int(11) NOT NULL,
  `animal` int(11) NOT NULL,
  `veterinarian` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `health` varchar(255) NOT NULL,
  `food` varchar(255) NOT NULL,
  `weight_of_food` varchar(255) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reports_veterinarian`
--

INSERT INTO `reports_veterinarian` (`id_report`, `animal`, `veterinarian`, `date`, `health`, `food`, `weight_of_food`, `comment`) VALUES
(1, 2, 'veto@arcadia.com', '2024-07-23', 'Grandi bien, en pleine forme', 'Varié (fruits et légumes)', '200g matin et soir', 'A pris 30g et 2cm cette semaine'),
(2, 2, 'veto@arcadia.com', '2024-07-24', 'En forme mais un peu fatigué', 'varié (fruits et légumes)', '200g matin et soir', ''),
(4, 4, 'veto@arcadia.com', '2024-08-05', 'Dumbo a une otite', 'Fruits', '50kgs par jour (pour le reste il se nourrit directement aux arbres)', ''),
(17, 18, 'veto@arcadia.com', '2024-08-06', 'Marty a un début de jaunisse', 'salade', '5kgs', ''),
(18, 14, 'veto@arcadia.com', '2024-08-06', 'Rivers a la gorge irrité', 'fruits et légumes', '5kgs', 'Traitement : 1 pipette de sirop pour la toux matin et soir'),
(19, 11, 'veto@arcadia.com', '2024-08-06', 'Bonne, prend du poids correctement', 'fruits et légumes', '40kgs', 'Gloria a pris 20kgs en 2 semaines'),
(21, 2, 'veto@arcadia.com', '2024-08-06', 'Marcel a pris 5cm!', 'Fruits et légumes', '250g par jour', ''),
(22, 1, 'aGator@arcadia.com', '2024-08-14', 'Début d\'arthrose', 'viande hachée', '15kg/jour', 'Shiva est âgée, c\'est normal.'),
(23, 8, 'veto@arcadia.com', '2024-08-28', 'Indigestion alimentaire', 'Rats, poussins 3x par semaine', '1 de chaque', 'Nez-rond a mal digéré les rats. Il peut être nécessaire de reprendre l\'ancien fournisseur.'),
(24, 28, 'aGator@arcadia.com', '2024-09-04', 'En pleine forme', 'Fruits', '500g par jour', ''),
(25, 21, 'aGator@arcadia.com', '2024-09-06', 'Déprime', 'Eucalypsus', '1kg par jour', 'Pretty boy a besoin d\'activités, il s\'ennui...'),
(26, 24, 'aGator@arcadia.com', '2024-09-07', 'En pleine forme', 'fruits legumes', '5kg tous les 2 jours', 'Fait des bonds de 1m'),
(27, 22, 'aGator@arcadia.com', '2024-09-07', 'Un peu en surpoids', 'fruits / légumes', '4kg tous les 2 jours', 'Roi Louie doit faire un peu d\'activité...');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `pseudo` varchar(18) NOT NULL,
  `date_visite` date NOT NULL,
  `note` tinyint(4) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date_check` date DEFAULT NULL,
  `check_by` varchar(255) DEFAULT NULL,
  `isVisible` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id_review`, `pseudo`, `date_visite`, `note`, `comment`, `date_check`, `check_by`, `isVisible`) VALUES
(13, 'Mimi_du_36', '2024-07-11', 5, 'Joli zoo, ombragé avec plein d\'espèces différentes. Il y a plein de banc ou d\'endroits pour s\'arrêter et pique-niquer. Il est vendu du mais soufflé pour nourrir certains animaux. \r\nA visiter !', '2024-07-11', 'bidon@arcadia.com', 1),
(18, 'Mamie gateaux', '2024-07-11', 5, 'Superbe . Ce zoo est à voir absolument. Les animaux sont très beau et cela se voit qu’ils sont bien traités, en bonne Santé . Même si beaucoup de monde en ce grand week-end nous pouvons les voir', '2024-07-11', 'raye.lucy@live.fr', 1),
(19, 'Jean-Pierre Ferot', '2024-07-11', 5, 'Expérience inoubliable. Nous y avons passé 7h. Parcours magnifique, les animaux vivent dans de bonnes conditions et sont très bien soignés. Un régal pour petits et grands', '2024-09-03', 'raye.lucy@live.fr', 1),
(20, 'lola', '2024-09-03', 4, 'Trop biennnnnn!', '2024-09-03', 'bidon@arcadia.com', 0);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `label` varchar(150) NOT NULL,
  `Détail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `label`, `Détail`) VALUES
(1, 'Administrateur.rice', 'Ajoute/modifie/supprime : animaux, services, habitats, utilisateurs\r\nmodifie horaires\r\nvoir les comptes-rendus médicaux, les repas, les statistiques des animaux'),
(2, 'Vétérinaire', 'Saisi les comptes rendus médicaux\r\nCommente les habitats\r\nVoir ce qu\'a mangé un animal'),
(3, 'Employé.e', 'Valide/invalide un avis\r\nModifie un service\r\nDonne l\'alimentation aux animaux');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id_service` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id_service`, `name`, `description`) VALUES
(41, 'Visite guidée', 'Découvrez notre zoo avec une visite guidée gratuite! Explorez la faune sauvage, apprenez sur la conservation et voyez de près nos animaux fascinants. Rejoignez-nous pour une expérience inoubliable et éducative pour toute la famille!'),
(44, 'Au naturel : restaurant eco-responsable', 'Découvrez notre restaurant où la nature est à l\'honneur. Nous vous proposons des plats savoureux, préparés avec des ingrédients locaux et biologiques. Chaque bouchée reflète notre engagement envers un avenir durable et respectueux de l\'environnement. '),
(56, 'Une visite en petit train', 'Embarquez pour une aventure unique en petit train à notre zoo! Explorez la faune fascinante tout en profitant d\'une balade confortable. Idéal pour toute la famille, cette visite vous garantit des souvenirs inoubliables. Venez vivre l\'aventure!'),
(67, 'Apprenti soigneur', 'Venez découvrir les coulisses de notre parc. Vous serez au plus proche des animaux et aurez le privilège d’en nourrir certains. Vous serez accompagné d’un soigneur durant 3 heures pour découvrir son passionnant métier. Tarif : 150€.');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `mail` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`mail`, `first_name`, `last_name`, `password`, `role`, `blocked`) VALUES
('aGator@arcadia.com', 'Ali', 'Gator', '$2y$10$/Vvb8BT01PrannaobtnAQObEVzFgmDuvfQ4Jea05kxJm9pEMMJGSi', 2, 0),
('bidon@arcadia.com', 'Terry', 'Kiki', '$2y$10$pJfiHuiCiCEil9Kx.3bqUe2gohwFp0cllFl5C4jeOkmAEl0MgUHSC', 3, 0),
('mErateur@arcadia.com', 'Mod', 'Erateur', '$2y$10$047wG.kueP1R/iq2Za6UBu68uhO9f2oz8/TOLh2cHMcwwC77fbHJq', 3, 0),
('raye.lucy@live.fr', 'José', 'Paledire', '$2y$10$tP.MFSXE0.S0JATUnonCNepT.ePK1lCqQYb.QXbbOvGV5qnGqVdBG', 1, 0),
('veto@arcadia.com', 'Laurent', 'Houtan', '123456789abc', 2, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id_animal`),
  ADD KEY `id_breed` (`breed`),
  ADD KEY `id_housing` (`housing`);

--
-- Index pour la table `breeds`
--
ALTER TABLE `breeds`
  ADD PRIMARY KEY (`id_breed`);

--
-- Index pour la table `comments_housing_veto`
--
ALTER TABLE `comments_housing_veto`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `mail` (`veterinarian`),
  ADD KEY `id_housing` (`housing`);

--
-- Index pour la table `fed_animals`
--
ALTER TABLE `fed_animals`
  ADD PRIMARY KEY (`id_fed`),
  ADD KEY `id_animal` (`animal`),
  ADD KEY `mail` (`employee`);

--
-- Index pour la table `housings`
--
ALTER TABLE `housings`
  ADD PRIMARY KEY (`id_housing`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_image`);

--
-- Index pour la table `images_animals`
--
ALTER TABLE `images_animals`
  ADD UNIQUE KEY `id_animal_2` (`id_animal`,`id_image`),
  ADD KEY `id_animal` (`id_animal`),
  ADD KEY `id_image` (`id_image`);

--
-- Index pour la table `images_housings`
--
ALTER TABLE `images_housings`
  ADD UNIQUE KEY `id_housing_2` (`id_housing`,`id_image`),
  ADD KEY `id_housing` (`id_housing`),
  ADD KEY `id_image` (`id_image`);

--
-- Index pour la table `images_services`
--
ALTER TABLE `images_services`
  ADD UNIQUE KEY `id_service_2` (`id_service`,`id_image`),
  ADD KEY `id_service` (`id_service`),
  ADD KEY `id_image` (`id_image`);

--
-- Index pour la table `reports_veterinarian`
--
ALTER TABLE `reports_veterinarian`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `id_animal` (`animal`),
  ADD KEY `mail` (`veterinarian`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `check_by` (`check_by`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`mail`),
  ADD KEY `id_role` (`role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animals`
--
ALTER TABLE `animals`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `breeds`
--
ALTER TABLE `breeds`
  MODIFY `id_breed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `comments_housing_veto`
--
ALTER TABLE `comments_housing_veto`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `fed_animals`
--
ALTER TABLE `fed_animals`
  MODIFY `id_fed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `housings`
--
ALTER TABLE `housings`
  MODIFY `id_housing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT pour la table `reports_veterinarian`
--
ALTER TABLE `reports_veterinarian`
  MODIFY `id_report` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_ibfk_1` FOREIGN KEY (`breed`) REFERENCES `breeds` (`id_breed`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `animals_ibfk_2` FOREIGN KEY (`housing`) REFERENCES `housings` (`id_housing`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments_housing_veto`
--
ALTER TABLE `comments_housing_veto`
  ADD CONSTRAINT `comments_housing_veto_ibfk_1` FOREIGN KEY (`housing`) REFERENCES `housings` (`id_housing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_housing_veto_ibfk_2` FOREIGN KEY (`veterinarian`) REFERENCES `users` (`mail`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `fed_animals`
--
ALTER TABLE `fed_animals`
  ADD CONSTRAINT `fed_animals_ibfk_1` FOREIGN KEY (`animal`) REFERENCES `animals` (`id_animal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fed_animals_ibfk_2` FOREIGN KEY (`employee`) REFERENCES `users` (`mail`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `images_animals`
--
ALTER TABLE `images_animals`
  ADD CONSTRAINT `images_animals_ibfk_2` FOREIGN KEY (`id_animal`) REFERENCES `animals` (`id_animal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_animals_ibfk_3` FOREIGN KEY (`id_image`) REFERENCES `images` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `images_housings`
--
ALTER TABLE `images_housings`
  ADD CONSTRAINT `images_housings_ibfk_1` FOREIGN KEY (`id_housing`) REFERENCES `housings` (`id_housing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_housings_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `images` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `images_services`
--
ALTER TABLE `images_services`
  ADD CONSTRAINT `images_services_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `images` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_services_ibfk_3` FOREIGN KEY (`id_service`) REFERENCES `services` (`id_service`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reports_veterinarian`
--
ALTER TABLE `reports_veterinarian`
  ADD CONSTRAINT `reports_veterinarian_ibfk_1` FOREIGN KEY (`animal`) REFERENCES `animals` (`id_animal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_veterinarian_ibfk_2` FOREIGN KEY (`veterinarian`) REFERENCES `users` (`mail`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`check_by`) REFERENCES `users` (`mail`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id_role`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

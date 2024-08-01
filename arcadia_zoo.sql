-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 01 août 2024 à 11:04
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
(1, 'Shiva', 3, 1, 1),
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
(15, 'Gigi l\'amoro', 16, 2, 1),
(16, 'Bob', 17, 2, 1),
(17, 'Miro', 18, 2, 1),
(18, 'Marty', 19, 2, 1),
(19, 'Moufasa', 5, 2, 1),
(20, 'Simba', 5, 2, 1),
(21, 'Pretty boy', 20, 1, 1),
(22, 'Roi Louie', 13, 1, 1),
(23, 'Serge', 14, 1, 1),
(24, 'Faloo', 21, 1, 1),
(25, 'Red', 21, 1, 1);

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
(1, 'Chimpanzé (singe)'),
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
(21, 'Kangourou');

-- --------------------------------------------------------

--
-- Structure de la table `comments_housing_veto`
--

CREATE TABLE `comments_housing_veto` (
  `id_comment` int(11) NOT NULL,
  `veterinarian` varchar(255) NOT NULL,
  `housing` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fed_animals`
--

CREATE TABLE `fed_animals` (
  `id_fed` int(11) NOT NULL,
  `animal` int(11) NOT NULL,
  `employee` varchar(255) NOT NULL,
  `food` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `housings`
--

CREATE TABLE `housings` (
  `id_housing` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `theme_color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `housings`
--

INSERT INTO `housings` (`id_housing`, `name`, `description`, `theme_color`) VALUES
(1, 'La jungle', 'forêt tropicale, à la végétation épaisse et luxuriante, dont l\'une des principales caractéristiques est sa canopée dense aux arbres hauts, créant un couvert végétal presque impénétrable.', 'vert'),
(2, 'La savane', 'paysage d\'herbes tropicales ou subtropicales avec une croissance arborescente dispersée où la végétation y est prédominante.', 'marron'),
(3, 'Le marais', 'zone humide avec des eaux stagnantes où s\'accumulent des sédiments sur une faible épaisseur.', 'blue'),
(4, 'La volière', 'Sont aussi bien présents des oiseaux de petites tailles que des grands. Elle offre bien plus qu’un simple espace de vol. C’est un lieu de vie et d’échange dans lequel vous pouvez observer la faune en toute liberté.', 'blue');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id_image` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `icon` tinyint(1) NOT NULL DEFAULT 0,
  `portrait` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id_image`, `path`, `description`, `icon`, `portrait`) VALUES
(2, 'View/assets/img/housings/1/2.jpg', 'Trois singes jouant dans un arbre', 0, 0),
(3, 'View/assets/img/housings/2/3.jpg', 'Pleins de girafes gambadants', 0, 0),
(4, 'View/assets/img/housings/3/4.jpg', 'Une petite fille admirant un aquarium de pirhannas', 0, 0),
(5, 'View/assets/img/animals/2-Marcel/Marcel1.jpg', 'Le bébé chimpanzé Marcel tout mignon dans un arbre', 0, 0),
(6, 'View/assets/img/animals/10-Cléopatre/Cléopatre1.jpg', 'Cléopatre la léoparde regardant devant elle', 0, 0),
(7, 'View/assets/img/animals/1-Shiva/Shiva1.jpg', 'Le tigre Shiva, marchant fièrement regardant devant soit.', 0, 0),
(8, 'View/assets/img/animals/4-Dumbo/Dumbo1.jpg', 'La tête de Dumbo l\'éléphant recouverte de terre avec la trompe en l\'air.', 0, 0),
(9, 'View/assets/img/animals/5-Prince Edward/Prince Edward1.jpg', 'Le lion prince Edward fièrement avachi par terre.', 0, 0),
(10, 'View/assets/img/animals/6-Rocky/Rocky1.jpg', 'La tête de Rocky le rhinocéros marchant dans l\'herbe.', 0, 1),
(11, 'View/assets/img/animals/7-Lacoste/Lacoste1.jpg', 'Lacoste, crocodile, sortant de l\'eau et levant bien haut la tête.', 0, 0),
(12, 'View/assets/img/animals/8-Nez-rond/Nez-rond1.jpg', 'Tête de Nez-rond l\'aligator, sautant de l\'eau.', 0, 0),
(13, 'View/assets/img/animals/9-Shakira/Shakira1.jpg', 'Shakira, serpant à la couleur vert flashy, enroulée autour d\'une branche.', 0, 0),
(14, 'View/assets/img/animals/11-Gloria/Gloria1.jpg', 'La tête de Gloria, l\'hyppopotame sortant de l\'eau.', 0, 0),
(15, 'View/assets/img/animals/11-Gloria/Gloria2.jpg', 'Gloria, l\'hyppopotame, prend la pose dans l\'eau.', 0, 0),
(16, 'View/assets/img/animals/6-Rocky/Rocky2.jpg', 'Tête du rhinocéros Rocky pris de coté.', 0, 0),
(35, 'View/assets/img/services/41/icon.png', 'Null', 1, 0),
(36, 'View/assets/img/services/41/photo1.jpg', 'Employé du zoo tenant un bébé caïman.', 0, 1),
(41, 'View/assets/img/services/44/icon.png', 'Null', 1, 0),
(42, 'View/assets/img/services/44/photo1.jpg', 'Chef déposant délicatement sur un tronc des mets', 0, 0),
(65, 'View/assets/img/services/56/icon.png', 'Null', 1, 0),
(66, 'View/assets/img/services/56/photo1.jpg', 'Nos deux petits trains (orange et bleu).', 0, 0),
(82, 'View/assets/img/services/66/icon.png', 'Null', 1, 0),
(83, 'View/assets/img/services/66/photo1.jpg', 'Soigneur jouant avec des petits singes', 0, 1),
(84, 'View/assets/img/animals/2-Marcel/Marcel2.jpg', 'Marcel, petit chimpanzé, se cache dans un arbre', 0, 0),
(91, 'View/assets/img/animals/1-Shiva/Shiva-1722256004.jpg', 'NULL', 0, 0),
(93, 'View/assets/img/animals/1-Shiva/Shiva-1722256204.jpg', 'NULL', 0, 0),
(157, 'View/assets/img/housings/1/1.jpg', 'Tigre s\'abreuvant', 0, 0),
(158, 'View/assets/img/housings/3/5.jpg', 'La cabane d\'observation perdu dans le marais.', 0, 0);

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
(11, 15);

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
(3, 158);

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
(66, 82),
(66, 83);

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
(2, 2, 'veto@arcadia.com', '2024-07-24', 'En forme mais un peu fatigué', 'varié (fruits et légumes)', '200g matin et soir', '');

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
(13, 'Mimi_du_36', '2024-07-11', 5, 'Joli zoo, ombragé avec plein d\'espèces différentes. Il y a plein de banc ou d\'endroits pour s\'arrêter et pique-niquer. Il est vendu du mais soufflé pour nourrir certains animaux. \r\nA visiter !', '2024-07-11', 'bidon@arcadia.fr', 1),
(18, 'Mamie gateaux', '2024-07-11', 5, 'Superbe . Ce zoo est à voir absolument. Les animaux sont très beau et cela se voit qu’ils sont bien traités, en bonne Santé . Même si beaucoup de monde en ce grand week-end nous pouvons les voir', '2024-07-11', 'raye.lucy@live.fr', 1),
(19, 'Jean-Pierre Ferot', '2024-07-11', 5, 'Expérience inoubliable. Nous y avons passé 7h. Parcours magnifique, les animaux vivent dans de bonnes conditions et sont très bien soignés. Un régal pour petits et grands', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `label` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `label`) VALUES
(1, 'Administrateur.rice'),
(2, 'Vétérinaire'),
(3, 'Employé.e');

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
(66, 'Apprenti soigneur', 'Venez découvrir les coulisses de notre parc. Vous serez au plus proche des animaux et aurez le privilège d’en nourrir certains. Vous serez accompagné d’un soigneur durant 3 heures pour découvrir son passionnant métier. Tarif : 150€.');

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
('bidon@arcadia.fr', 'Jesus', 'Bidon', '1234', 3, 0),
('raye.lucy@live.fr', 'José', 'Garcia', '$2y$10$tP.MFSXE0.S0JATUnonCNepT.ePK1lCqQYb.QXbbOvGV5qnGqVdBG', 1, 0),
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
  ADD KEY `mail` (`check_by`);

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
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `breeds`
--
ALTER TABLE `breeds`
  MODIFY `id_breed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `comments_housing_veto`
--
ALTER TABLE `comments_housing_veto`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fed_animals`
--
ALTER TABLE `fed_animals`
  MODIFY `id_fed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `housings`
--
ALTER TABLE `housings`
  MODIFY `id_housing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT pour la table `reports_veterinarian`
--
ALTER TABLE `reports_veterinarian`
  MODIFY `id_report` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`check_by`) REFERENCES `users` (`mail`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id_role`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

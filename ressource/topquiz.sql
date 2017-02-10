-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 10 Février 2017 à 17:55
-- Version du serveur :  5.7.17-0ubuntu0.16.04.1
-- Version de PHP :  7.0.13-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `topquiz`
--

-- --------------------------------------------------------

--
-- Structure de la table `lnk_Question_Reponse`
--

CREATE TABLE `lnk_Question_Reponse` (
  `id_question` int(10) UNSIGNED NOT NULL,
  `id_reponse` int(10) UNSIGNED NOT NULL,
  `reponse_juste` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `lnk_Question_Reponse`
--

INSERT INTO `lnk_Question_Reponse` (`id_question`, `id_reponse`, `reponse_juste`) VALUES
(1, 1, NULL),
(1, 2, 1),
(1, 3, NULL),
(1, 4, NULL),
(2, 5, NULL),
(2, 6, NULL),
(2, 7, 1),
(2, 8, NULL),
(3, 9, NULL),
(3, 10, 1),
(3, 11, NULL),
(3, 12, NULL),
(4, 13, 1),
(4, 14, NULL),
(4, 15, NULL),
(4, 16, NULL),
(5, 17, NULL),
(5, 18, NULL),
(5, 19, 1),
(5, 20, NULL),
(6, 21, NULL),
(6, 22, 1),
(6, 23, NULL),
(6, 24, NULL),
(7, 25, NULL),
(7, 26, NULL),
(7, 27, NULL),
(7, 28, 1),
(8, 29, 1),
(8, 30, NULL),
(8, 31, NULL),
(8, 32, NULL),
(9, 33, NULL),
(9, 34, NULL),
(9, 35, 1),
(9, 36, NULL),
(10, 37, NULL),
(10, 38, 1),
(10, 39, NULL),
(10, 40, NULL),
(11, 41, 1),
(11, 42, NULL),
(11, 43, NULL),
(11, 44, NULL),
(12, 45, 1),
(12, 46, NULL),
(12, 47, NULL),
(12, 48, NULL),
(13, 49, 1),
(13, 50, 1),
(13, 51, NULL),
(13, 52, NULL),
(13, 53, 1);

-- --------------------------------------------------------

--
-- Structure de la table `lnk_Utilisateur_Quiz`
--

CREATE TABLE `lnk_Utilisateur_Quiz` (
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `id_quiz` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `lnk_Utilisateur_Quiz`
--

INSERT INTO `lnk_Utilisateur_Quiz` (`id_utilisateur`, `id_quiz`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Question`
--

CREATE TABLE `Question` (
  `id` int(10) UNSIGNED NOT NULL,
  `contenu` varchar(200) NOT NULL,
  `id_quiz` int(10) UNSIGNED DEFAULT NULL,
  `type` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Question`
--

INSERT INTO `Question` (`id`, `contenu`, `id_quiz`, `type`) VALUES
(1, 'À quel niveau du jeu apparaissent les Superballs ?', 1, 0),
(2, 'Quel est le nom de la société qui a créé le jeu Pokémon GO ?', 1, 0),
(3, 'Quel animal est Kurama ?', 2, 0),
(4, 'Qu\'a perdu Shanks pour sauver Luffy ?', 2, 0),
(5, 'Quel élément est le pouvoir de Juvia ?', 2, 0),
(6, 'Avec quelle arme se bat Kirito ?', 2, 0),
(7, 'Qui est le meilleur ami de Gon ?', 2, 0),
(8, 'Dans quel animé retrouve t\'on la ville de karakura ?', 2, 0),
(9, 'Qui est Saya dans Blood+ ?', 2, 0),
(10, 'Comment meurt Fuuka dans le manga du même nom ?', 2, 0),
(11, 'Quelle est la spécialité de Soma ?', 2, 0),
(12, 'Quel jeu se pratique dans Chihayafuru ?', 2, 0),
(13, 'Quelle distance doit-on marcher pour faire éclore un oeuf ?', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Quiz`
--

CREATE TABLE `Quiz` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Quiz`
--

INSERT INTO `Quiz` (`id`, `nom`) VALUES
(1, 'Test tes connaissances sur Pokemon GO'),
(2, 'Quizz Manga');

-- --------------------------------------------------------

--
-- Structure de la table `Reponse`
--

CREATE TABLE `Reponse` (
  `id` int(10) UNSIGNED NOT NULL,
  `contenu` varchar(200) NOT NULL,
  `id_question` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Reponse`
--

INSERT INTO `Reponse` (`id`, `contenu`, `id_question`) VALUES
(1, 'Au niveau 8', 1),
(2, 'Au niveau 12', 1),
(3, 'Au niveau 20', 1),
(4, 'Au niveau 21', 1),
(5, 'Microsoft', 2),
(6, 'Ankama', 2),
(7, 'Niantic', 2),
(8, 'Ubisoft', 2),
(9, 'une pieuvre', 3),
(10, 'un renard', 3),
(11, 'une tortue', 3),
(12, 'un gorille', 3),
(13, 'bras gauche', 4),
(14, 'bras droit', 4),
(15, 'jambe gauche', 4),
(16, 'jambe droite', 4),
(17, 'la glace', 5),
(18, 'le vent', 5),
(19, 'l\'eau', 5),
(20, 'le feu', 5),
(21, 'un pistolet', 6),
(22, 'des épées', 6),
(23, 'une hache', 6),
(24, 'à main nue', 6),
(25, 'kurapika', 7),
(26, 'leorio', 7),
(27, 'hisoka', 7),
(28, 'kirua', 7),
(29, 'bleach', 8),
(30, 'sword art online', 8),
(31, 'shingeki no kyojin', 8),
(32, 'dragon ball super', 8),
(33, 'un loup garou', 9),
(34, 'une licorne', 9),
(35, 'un dragon', 9),
(36, 'un vampire', 9),
(37, 'en tombant dans les escaliers', 10),
(38, 'renversé par un véhicule', 10),
(39, 'en s\'électrocutant', 10),
(40, 'en se noyant', 10),
(41, 'la cuisine', 11),
(42, 'le karaté', 11),
(43, 'la danse', 11),
(44, 'le chant', 11),
(45, 'le karuta', 12),
(46, 'le fuda', 12),
(47, 'le sugoroku', 12),
(48, 'le kendama', 12),
(49, '1km', 13),
(50, '2km', 13),
(51, '3km', 13),
(52, '4km', 13),
(53, '5km', 13);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `pseudo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `login`, `password`, `pseudo`) VALUES
(1, 'jojo', 'test', 'test2');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `lnk_Question_Reponse`
--
ALTER TABLE `lnk_Question_Reponse`
  ADD KEY `question_id` (`id_question`,`id_reponse`),
  ADD KEY `fk_reponse_id` (`id_reponse`);

--
-- Index pour la table `lnk_Utilisateur_Quiz`
--
ALTER TABLE `lnk_Utilisateur_Quiz`
  ADD KEY `fk_id_utilisateur` (`id_utilisateur`),
  ADD KEY `fk_id_quiz_utilisateur` (`id_quiz`);

--
-- Index pour la table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_quiz` (`id_quiz`);

--
-- Index pour la table `Quiz`
--
ALTER TABLE `Quiz`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Reponse`
--
ALTER TABLE `Reponse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_question` (`id_question`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Question`
--
ALTER TABLE `Question`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `Quiz`
--
ALTER TABLE `Quiz`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Reponse`
--
ALTER TABLE `Reponse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `lnk_Question_Reponse`
--
ALTER TABLE `lnk_Question_Reponse`
  ADD CONSTRAINT `fk_question_id` FOREIGN KEY (`id_question`) REFERENCES `Question` (`id`),
  ADD CONSTRAINT `fk_reponse_id` FOREIGN KEY (`id_reponse`) REFERENCES `Reponse` (`id`);

--
-- Contraintes pour la table `lnk_Utilisateur_Quiz`
--
ALTER TABLE `lnk_Utilisateur_Quiz`
  ADD CONSTRAINT `fk_id_quiz_utilisateur` FOREIGN KEY (`id_quiz`) REFERENCES `Quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `fk_id_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `Quiz` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `Reponse`
--
ALTER TABLE `Reponse`
  ADD CONSTRAINT `fk_id_question` FOREIGN KEY (`id_question`) REFERENCES `Question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

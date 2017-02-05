-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 05 Février 2017 à 22:07
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
-- Structure de la table `Question`
--

CREATE TABLE `Question` (
  `id` int(10) UNSIGNED NOT NULL,
  `contenu` varchar(200) NOT NULL,
  `id_quiz` int(10) UNSIGNED DEFAULT NULL,
  `id_bonne_reponse` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Question`
--

INSERT INTO `Question` (`id`, `contenu`, `id_quiz`, `id_bonne_reponse`) VALUES
(1, 'À quel niveau du jeu apparaissent les Superballs ?', 1, 2),
(2, 'Quel est le nom de la société qui a créé le jeu Pokémon GO ?', 1, 7),
(3, 'Quel animal est Kurama ?', 2, 10),
(4, 'Qu\'a perdu Shanks pour sauver Luffy ?', 2, 13),
(5, 'Quel élément est le pouvoir de Juvia ?', 2, 19),
(6, 'Avec quelle arme se bat Kirito ?', 2, 22),
(7, 'Qui est le meilleur ami de Gon ?', 2, 28),
(8, 'Dans quel animé retrouve t\'on la ville de karakura ?', 2, 29),
(9, 'Qui est Saya dans Blood+ ?', 2, 35),
(10, 'Comment meurt Fuuka dans le manga du même nom ?', 2, 38),
(11, 'Quelle est la spécialité de Soma ?', 2, 41),
(12, 'Quel jeu se pratique dans Chihayafuru ?', 2, 45);

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
(48, 'le kendama', 12);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_quiz` (`id_quiz`),
  ADD KEY `fk_bonne_reponse` (`id_bonne_reponse`);

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
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Question`
--
ALTER TABLE `Question`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `Quiz`
--
ALTER TABLE `Quiz`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Reponse`
--
ALTER TABLE `Reponse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `fk_bonne_reponse` FOREIGN KEY (`id_bonne_reponse`) REFERENCES `Reponse` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `Quiz` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `Reponse`
--
ALTER TABLE `Reponse`
  ADD CONSTRAINT `fk_id_question` FOREIGN KEY (`id_question`) REFERENCES `Question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

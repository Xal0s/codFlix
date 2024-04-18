-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 18 avr. 2024 à 16:52
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
-- Base de données : `codflix`
--

-- --------------------------------------------------------

--
-- Structure de la table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `episode_num` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `episode_url` varchar(255) NOT NULL,
  `duration` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `episodes`
--

INSERT INTO `episodes` (`id`, `episode_num`, `name`, `episode_url`, `duration`, `date`) VALUES
(1, 1, 'Robocop', 'https://www.youtube.com/embed/7Go9qIxotkk', '00:39:21', '2023-12-02'),
(2, 1, 'Bref. Je me suis préparé pour un rendez-vous', 'https://www.youtube.com/embed/1x3P61ck0QI', '00:01:45', '2017-10-13'),
(3, 2, 'Bref. J\'ai passé un entretient d\'embauche', 'https://www.youtube.com/embed/7_VQCD863CU', '00:01:45', '2017-11-15'),
(4, 1, 'Bref. Je suis comme tout le monde.', 'https://www.youtube.com/embed/tkMoSaUMsiM', '00:01:30', '2018-04-12'),
(5, 1, 'Bref. J\'ai eu 47 minutes de retard.', 'https://www.youtube.com/embed/K0XI5d8080Q', '00:01:37', '2019-01-15');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Horreur'),
(3, 'Science-Fiction');

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `finish_date` datetime DEFAULT NULL,
  `watch_duration` int(11) NOT NULL DEFAULT 0 COMMENT 'in seconds'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE `medias` (
  `id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `release_date` date NOT NULL,
  `summary` longtext NOT NULL,
  `trailer_url` varchar(100) NOT NULL,
  `season_nbr` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `medias`
--

INSERT INTO `medias` (`id`, `genre_id`, `title`, `type`, `status`, `release_date`, `summary`, `trailer_url`, `season_nbr`) VALUES
(1, 1, 'Die Hard', 'film', '', '1988-07-15', 'À l\'occasion du réveillon de Noël, John McClane, lieutenant de la police de New York, décide d\'aller rendre visite à sa femme Holly à Los Angeles, malgré leur séparation et leur relation tumultueuse. Holly travaille pour une entreprise japonaise, qui inaugure son immense tour, le Nakatomi Plaza. C\'est ce jour que choisit le criminel Hans Gruber pour mettre à exécution son plan de dérober 640 millions de dollars au palace et de prendre le personnel sur place en otage, la femme de McClane y compris. John, qui a échappé à l\'assaut mais qui est toujours prisonnier du gratte-ciel, part alors en guerre contre les preneurs d\'otages.', 'https://www.youtube.com/embed/gYWvwkXreaI', NULL),
(2, 2, 'IT', 'film', '', '2017-09-08', 'À Derry, dans le Maine, sept adolescents ayant du mal à s\'intégrer se sont regroupés au sein du « Club des Ratés ». Rejetés par leurs camarades, ils sont les cibles favorites des gros durs de l\'école. Ils ont aussi en commun le fait d\'avoir éprouvé leur plus grande terreur face à un terrible prédateur métamorphe qu\'ils appellent « Ça ». Car depuis toujours, Derry est en proie à une créature qui émerge des égouts tous les 27 ans pour se nourrir des terreurs de ses victimes de choix : les enfants. Bien décidés à rester soudés, les Ratés tentent de surmonter leurs peurs pour enrayer un nouveau cycle meurtrier. Un cycle qui a commencé un jour de pluie lorsqu\'un petit garçon poursuivant son bateau en papier s\'est retrouvé face-à-face avec un clown répondant au nom de Grippe-Sou...', 'https://www.youtube.com/embed/WHcLFkL8ulo', NULL),
(3, 3, 'Inception', 'film', '', '2010-07-21', 'Dom Cobb est un voleur expérimenté – le meilleur qui soit dans l’art périlleux de l’extraction : sa spécialité consiste à s’approprier les secrets les plus précieux d’un individu, enfouis au plus profond de son subconscient, pendant qu’il rêve et que son esprit est particulièrement vulnérable. Très recherché pour ses talents dans l’univers trouble de l’espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier qui a perdu tout ce qui lui est cher. Mais une ultime mission pourrait lui permettre de retrouver sa vie d’avant – à condition qu’il puisse accomplir l’impossible : l’inception. Au lieu de subtiliser un rêve, Cobb et son équipe doivent faire l’inverse : implanter une idée dans l’esprit d’un individu. S’ils y parviennent, il pourrait s’agir du crime parfait. Et pourtant, aussi méthodiques et doués soient-ils, rien n’aurait pu préparer Cobb et ses partenaires à un ennemi redoutable qui semble avoir systématiquement un coup d’avance sur eux. Un ennemi dont seul Cobb aurait pu soupçonner l’existence.', 'https://www.youtube.com/embed/CPTIgILtna8', NULL),
(4, 1, 'Bref.', 'serie', '', '2011-04-13', 'Les chroniques extraordinaires d’un homme ordinaire. Dans la vie, au début on naît, à la fin on meurt, pendant ce temps là, il se passe des trucs. Bref, c\'est la vie d\'un mec pendant ce temps là.', 'https://www.youtube.com/embed/UO8tcf3U0dY', 3),
(6, 3, 'Joueur du Grenier', 'serie', '', '2009-08-24', 'Dans la petite ville de Rétroland, où les pixels et les polygones règnent en maîtres, vit un héros pas comme les autres : Joueur du Grenier. Derrière ce pseudonyme se cache Frédéric, un trentenaire passionné de jeux vidéo rétro. Accompagné de son fidèle acolyte, Sébastien, alias \"Seb\", ce duo improbable s\'attaque aux pires jeux de l\'histoire vidéoludique.  Dans chaque épisode, Joueur du Grenier se lance courageusement dans l\'univers impitoyable des jeux rétro, prêt à affronter des ennemis redoutables, des contrôles inadaptés et des bugs impardonnables. Armé de son humour cinglant et de sa répartie acérée, notre héros n\'hésite pas à déterrer les pépites oubliées de l\'ère vidéoludique, tout en dénonçant avec ferveur les titres les plus catastrophiques.', 'https://www.youtube.com/embed/ds5OSFbO4gc', 5),
(7, 3, 'Le Visiteur du Futur', 'serie', '', '2010-10-03', '2555. Dans un futur dévasté, l’apocalypse menace la Terre. Le dernier espoir repose sur un homme capable de voyager dans le temps. Sa mission : retourner dans le passé et changer le cours des événements. Mais la Brigade Temporelle, une police du temps, le traque à chaque époque. Débute alors une course contre la montre pour le Visiteur du Futur…', 'https://www.youtube.com/embed/eaHYgSCgUnw', 3);

-- --------------------------------------------------------

--
-- Structure de la table `seasons`
--

CREATE TABLE `seasons` (
  `season_num` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `seasons`
--

INSERT INTO `seasons` (`season_num`, `serie_id`, `episode_id`) VALUES
(1, 6, 1),
(1, 4, 2),
(1, 4, 3),
(2, 4, 5),
(3, 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(80) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `account_activation_token` varchar(64) DEFAULT NULL,
  `is_activated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `reset_token_hash`, `reset_token_expires`, `account_activation_token`, `is_activated`) VALUES
(1, 'coding@factory.fr', '123456', NULL, NULL, NULL, 1),
(31, 'kevin.pereira@edu.esiee-it.fr', 'c95e18a00b0db37aa444777161834e3735e31d3d55266871e76ade9497c49275', NULL, NULL, '66211bd48a097', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_user_id_fk_media_id` (`user_id`),
  ADD KEY `history_media_id_fk_media_id` (`media_id`);

--
-- Index pour la table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_genre_id_fk_genre_id` (`genre_id`) USING BTREE;

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_media_id_fk_media_id` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_user_id_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `media_genre_id_b1257088_fk_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

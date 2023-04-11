-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 11 avr. 2023 à 11:34
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shortener`
--

-- --------------------------------------------------------

--
-- Structure de la table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `long_url` varchar(255) NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `links`
--

INSERT INTO `links` (`id`, `long_url`, `short_url`, `created_at`, `id_user`) VALUES
(5, 'https://www.codeur.com/tuto/creation-de-site-internet/comment-creer-extension-google-chrome/', 'extension', '2023-01-26 20:40:42', 6),
(6, 'https://www.000webhost.com/cpanel-login?from=panel', 'webhost', '2023-01-28 21:30:55', 6),
(7, 'https://www.techno-science.net/definition/6192.html', 'algos', '2023-01-28 21:33:13', 6),
(8, 'https://mail.google.com/mail/u/0/#sent/KtbxLvHLrHhPFKPNwNrmXzMtSzrkpwQkVV', 'mails', '2023-01-30 22:41:48', 6);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `motdepasseoublie` varchar(255) NOT NULL,
  `nbre_url` int(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `date_creation_compte` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `motdepasse`, `email`, `motdepasseoublie`, `nbre_url`, `is_admin`, `date_creation_compte`) VALUES
(4, 'dfdf', 'cfa6610e60790697720b179ddbfce109', 'dfdffd@gmail.com', '', 0, 0, '2023-01-24 23:08:57'),
(5, 'Friedrich', '87caf38b04d47d4522de9f87422d3e88', 'dfdfdf@gmail.com', '', 0, 0, '2023-01-24 23:10:35'),
(6, 'Fred', 'bd3484138d8cce2af399405e49e92f2e', 'fr@gmail.com', '', 0, 0, '2023-01-24 23:19:28'),
(7, 'Sert', '531f8151c0ff9fc2e4d09bf737c634e6', 'fredthedev18@proton.me', '3srBtqJx9vAmT6TmFxsG', 0, 0, '2023-01-25 01:54:09');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `User_id` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `User_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

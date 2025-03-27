<?php
// Fichier: voyages.php

// Définition du fichier CSV pour stocker les voyages
define('FICHIER_VOYAGES', 'data/voyages.csv');
define('FICHIER_ETAPES', 'data/etapes.csv');
define('FICHIER_OPTIONS', 'data/options.csv');

/**
 * Fonction pour récupérer la liste des voyages
 */
function getVoyages() {
    $voyages = [];
    if (($handle = fopen(FICHIER_VOYAGES, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $voyages[] = $data;
        }
        fclose($handle);
    }
    return $voyages;
}

/**
 * Fonction pour récupérer un voyage par ID
 */
function getVoyageById($id) {
    $voyages = getVoyages();
    foreach ($voyages as $voyage) {
        if ($voyage[0] == $id) {
            return $voyage;
        }
    }
    return null;
}

/**
 * Fonction pour ajouter un voyage
 */
function ajouterVoyage($id, $nom, $description, $prix) {
    $file = fopen(FICHIER_VOYAGES, 'a');
    fputcsv($file, [$id, $nom, $description, $prix]);
    fclose($file);
}

/**
 * Fonction pour modifier un voyage
 */
function modifierVoyage($id, $nom, $description, $prix) {
    $voyages = getVoyages();
    $file = fopen(FICHIER_VOYAGES, 'w');
    foreach ($voyages as $voyage) {
        if ($voyage[0] == $id) {
            fputcsv($file, [$id, $nom, $description, $prix]);
        } else {
            fputcsv($file, $voyage);
        }
    }
    fclose($file);
}

/**
 * Fonction pour supprimer un voyage
 */
function supprimerVoyage($id) {
    $voyages = getVoyages();
    $file = fopen(FICHIER_VOYAGES, 'w');
    foreach ($voyages as $voyage) {
        if ($voyage[0] != $id) {
            fputcsv($file, $voyage);
        }
    }
    fclose($file);
}

/**
 * Fonction pour récupérer les étapes d'un voyage
 */
function getEtapesByVoyageId($voyageId) {
    $etapes = [];
    if (($handle = fopen(FICHIER_ETAPES, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if ($data[1] == $voyageId) { // Vérifie si l'étape appartient à ce voyage
                $etapes[] = $data;
            }
        }
        fclose($handle);
    }
    return $etapes;
}

/**
 * Fonction pour récupérer les options d'un voyage
 */
function getOptionsByVoyageId($voyageId) {
    $options = [];
    if (($handle = fopen(FICHIER_OPTIONS, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if ($data[1] == $voyageId) { // Vérifie si l'option appartient à ce voyage
                $options[] = $data;
            }
        }
        fclose($handle);
    }
    return $options;
}

?>

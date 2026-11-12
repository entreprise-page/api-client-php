<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Model\SuiviAlerte;
use EntreprisePage\ApiClient\Model\SuiviConfigurationAlerte;
use EntreprisePage\ApiClient\Model\SuiviImportStatut;
use EntreprisePage\ApiClient\Model\SuiviListe;
use EntreprisePage\ApiClient\Model\SuiviListeEntreprise;
use EntreprisePage\ApiClient\Model\SuiviListes;
use EntreprisePage\ApiClient\Model\SuiviStatutEntreprise;

/**
 * Suivi d'entreprises de l'organisation rattachée à la clé d'API.
 *
 * Tous les endpoints nécessitent une clé d'API et ne consomment pas le quota.
 */
final class SuiviApi
{
    /**
     * @internal utiliser Client::suivi()
     */
    private Transport $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * GET /suivi/liste — les listes de l'organisation et le nombre maximum permis par son plan.
     */
    public function lists(): SuiviListes
    {
        return SuiviListes::fromArray($this->transport->get('/suivi/liste'));
    }

    /**
     * POST /suivi/liste — dans la limite du nombre de listes permis par le plan.
     *
     * @param string $name 50 caractères maximum
     */
    public function createList(string $name): SuiviListe
    {
        return SuiviListe::fromArray($this->transport->post('/suivi/liste', ['nom' => $name]));
    }

    /**
     * DELETE /suivi/liste/{listeId} — supprime aussi les entreprises qu'elle contient.
     */
    public function deleteList(int $listId): void
    {
        $this->transport->delete('/suivi/liste/'.Transport::segment($listId));
    }

    /**
     * GET /suivi/entreprise — entreprises d'une liste, triées par siren et paginées.
     *
     * Une pagination hors limites est ramenée dans les bornes par l'API.
     *
     * @param int|null $listId la première liste de l'organisation par défaut
     */
    public function companies(?int $listId = null, ?int $page = null, ?int $perPage = null): SuiviListeEntreprise
    {
        $query = [];
        if (null !== $listId) {
            $query['liste'] = (string) $listId;
        }
        if (null !== $page) {
            $query['page'] = (string) $page;
        }
        if (null !== $perPage) {
            $query['par_page'] = (string) $perPage;
        }

        return SuiviListeEntreprise::fromArray($this->transport->get('/suivi/entreprise', $query));
    }

    /**
     * GET /suivi/entreprise/{siren} — l'entreprise est-elle suivie dans au moins une liste ?
     */
    public function isFollowed(string $siren): bool
    {
        return SuiviStatutEntreprise::fromArray($this->transport->get('/suivi/entreprise/'.Transport::segment($siren)))->estSuivie;
    }

    /**
     * POST /suivi/liste/{listeId}/entreprise — dans la limite du nombre de suivis permis par le plan.
     */
    public function follow(int $listId, string $siren): void
    {
        $this->transport->postWithoutContent('/suivi/liste/'.Transport::segment($listId).'/entreprise', ['siren' => $siren]);
    }

    /**
     * POST /suivi/liste/{listeId}/import — ajoute plusieurs entreprises à une liste.
     *
     * Un siren invalide, introuvable ou au-delà du nombre maximum de suivis compte comme
     * une erreur sans interrompre l'import ; un siren déjà suivi compte comme un succès.
     *
     * @param list<string>|string $sirens liste de siren, ou chaîne séparée par des virgules, des points-virgules, des espaces ou des retours à la ligne (un seul type de séparateur)
     */
    public function import(int $listId, $sirens): SuiviImportStatut
    {
        if (\is_array($sirens)) {
            $sirens = implode(',', $sirens);
        }

        return SuiviImportStatut::fromArray($this->transport->post('/suivi/liste/'.Transport::segment($listId).'/import', ['sirens' => $sirens]));
    }

    /**
     * DELETE /suivi/liste/{listeId}/entreprise/{siren} — l'entreprise reste suivie dans les autres listes.
     */
    public function removeFromList(int $listId, string $siren): void
    {
        $this->transport->delete('/suivi/liste/'.Transport::segment($listId).'/entreprise/'.Transport::segment($siren));
    }

    /**
     * DELETE /suivi/entreprise/{siren} — retire l'entreprise de toutes les listes de l'organisation.
     */
    public function unfollow(string $siren): void
    {
        $this->transport->delete('/suivi/entreprise/'.Transport::segment($siren));
    }

    /**
     * GET /suivi/liste/{listeId}/alerte — une liste sans alerte renvoie une alerte inactive.
     */
    public function alert(int $listId): SuiviAlerte
    {
        return SuiviAlerte::fromArray($this->transport->get('/suivi/liste/'.Transport::segment($listId).'/alerte'));
    }

    /**
     * PUT /suivi/liste/{listeId}/alerte — remplace toute l'alerte de la liste.
     *
     * Une alerte active demande au moins un événement (voir SuiviAlerte::$evenementsDisponibles)
     * et un canal actif. Un canal désactivé garde sa configuration.
     */
    public function configureAlert(int $listId, SuiviConfigurationAlerte $alert): SuiviAlerte
    {
        return SuiviAlerte::fromArray($this->transport->put('/suivi/liste/'.Transport::segment($listId).'/alerte', [
            'active' => $alert->active,
            'evenements' => $alert->evenements,
            'email' => [
                'active' => $alert->email->active,
                'adresses' => $alert->email->adresses,
            ],
            'webhook' => [
                'active' => $alert->webhook->active,
                'url' => $alert->webhook->url,
                'token' => $alert->webhook->token,
            ],
        ]));
    }

    /**
     * POST /suivi/liste/{listeId}/alerte/activer — l'alerte doit avoir un événement et un canal actif.
     */
    public function enableAlert(int $listId): SuiviAlerte
    {
        return SuiviAlerte::fromArray($this->transport->post('/suivi/liste/'.Transport::segment($listId).'/alerte/activer'));
    }

    /**
     * POST /suivi/liste/{listeId}/alerte/desactiver — la configuration est gardée.
     */
    public function disableAlert(int $listId): SuiviAlerte
    {
        return SuiviAlerte::fromArray($this->transport->post('/suivi/liste/'.Transport::segment($listId).'/alerte/desactiver'));
    }
}

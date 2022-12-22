# Introduction

API pour retrouver efficacement les deadlines du projet en fonction de leur date d'échéance et de leur statut.

---

## Prochaines deadlines

### Requête

```http
GET /api/nextdeadlines
```

Permet de retrouver toutes les deadlines non clôturées qui ont une date d'échéance avant le vendredi de la semaine suivante.

### Réponse

```json
{
  "title" : string,
  "nb_day" : string,
  "flag"    : string,
  "due_date" : date
}
```

L'attribut `title` fait référence au nom de la deadline.

L'attribut `nb_day` fait référence au nombre de jours entre la date d'aujourd'hui et celle d'échéance.

L'attribut `flag` fait référence à un message particulier pour la deadline comme par exemple "EN RETARD"

L'attribut `due_date` fait référence à la date d'échéance de la deadline

## Toutes les deadlines

### Requête

```http
GET /api/alldeadlines
```

Permet de retrouver toutes les deadlines non clôturées peu importe la date d'échéance.

### Réponse

```json
{
  "title" : string,
  "nb_day" : string,
  "flag"    : string,
  "due_date" : date
}
```

L'attribut `title` fait référence au nom de la deadline.

L'attribut `nb_day` fait référence au nombre de jours entre la date d'aujourd'hui et celle d'échéance.

L'attribut `flag` fait référence à un message particulier pour la deadline comme par exemple "EN RETARD"

L'attribut `due_date` fait référence à la date d'échéance de la deadline

## Clôturer une deadline

### Requête

```http
GET /api/donedeadline/{id}
```

Permet de clôturer une deadline en fonction de son identifiant unique.

| Paramètre | Type | Description |
| :--- | :--- | :--- |
| `id` | `integer` | **Requis**. Identifiant unique de la deadline |

### Réponse

```json
{
  "message" : string,
}
```

L'attribut `message` fait référence au message de succés de l'action

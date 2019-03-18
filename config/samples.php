<?php

return [
    'home' => [
        '0' => [
            'question' => "De quelle manière votre vie quotidienne est-elle touchée par le changement climatique ?",
            'response' =>
                "Pour le moment, je ne suis pas touchée dans ma vie quotidienne, sauf moralement, lorsque je vois des 
                populations entières déplacées ou souffrant à cause des tempêtes, etc...",
            'tags' => [
                "Elle est soucieuse pour d'autres victimes",
                "Elle souffre de la chaleur",
                "Elle a subi les dommages de tempêtes"],
            'explain' =>
                "Même correctement programmée, l'intelligence artificielle risque de répondre 
                \"Elle a subi les dommages de tempêtes\". La recherche de mots clefs va bien sûr trouver le mot
                \"tempêtes\", et elle aura beaucoup de mal à comprendre que la répondante ne parle pas de sa 
                propre situation mais de celles d'autres victimes ailleurs."
        ]
    ],
    'limits' => [
        '0' => [
            'title' => 'Contresens',
            'question' => "Faut-il prendre en compte le vote blanc et de quelle manière ?",
            'response' =>
                "Que se passerait-il si les votes blancs l'emportaient??? Il faudrait encore revoter!!! Non, il faut des 
                élections à un seul tour, comme dans la plupart des pays au monde!!!",
            'tags' => [
                "Il ne faut pas prendre en compte le vote blanc",
                "Il faut rendre le vote obligatoire",
                "Il faut tenir compte du vote blanc et revoter s'il gagne"],
            'explain' =>
                "Même correctement programmée, l'intelligence artificielle risque de répondre 
                \"Il faut tenir compte du vote blanc et revoter s'il arrive en tête\". 
                La recherche de mots clefs va bien sûr trouver le mot \"revoter\" et elle aura beaucoup de mal à 
                comprendre que la répondante ne souhaite pas de cette situation, car la négation n'arrive que dans la
                phrase suivante."
        ],
        '1' => [
            'title' => 'Confusion',
            'question' => "Quels sont selon vous les impôts qu'il faut baisser en priorité ?",
            'response' =>
                "Arrêtez de faire deux poids deux mesures, on supprime ou on garde la taxe d habitation pour tous. 
                Unifier les ponctions fiscales, au lieu d'avoir toute une série de lignes, revenu, csg etc etc.",
            'tags' => [
                "Pas forcément de baisse, mais il faut revoir et unifier",
                "Il faut baisser la TVA",
                "Il faut baisser la taxe d'habitation, la CSG et l'impôt sur le revenu"],
            'explain' =>
                "Même correctement programmée, l'intelligence artificielle risque de répondre 
                \"Il faut baisser la taxe d'habitation, la CSG et l'impôt sur le revenu\". 
                La recherche de mots clefs va bien sûr trouver les mots \"taxe d'habitation\", \"revenu\" et \"csg\",
                et, vu la tournure de la question, elle aura beaucoup de mal à comprendre que la répondante 
                ne demande pas vraiment de baisse, mais plutôt une simplification."
        ],
        '2' => [
            'title' => 'Incompréhension',
            'question' => "Que proposez-vous pour renforcer les principes de la laïcité dans le rapport entre l'Etat et les religions de notre pays ?",
            'response' =>
                "Les églises et temples...etc doivent être uniquement entretenu par les croyants. Les religieux sont un 
                monde vieux, dépassé et royaliste. Nous sommes en république",
            'tags' => [
                "L'Etat ne doit pas financer la rénovation de lieux de culte",
                "Il faut alléger les sanctions",
                "Autres"],
            'explain' =>
                "Même correctement programmée, l'intelligence artificielle risque de répondre 
                \"Autres\". La recherche de mots clefs aura beaucoup de mal à percevoir le sujet du financement 
                et la demande exacte de la répondante. En effet, le message est sous-entendu, la phrase importante
                est scindée en deux, et ni le terme \"financement\" ni \"Etat\" ne sont présents."
        ]
    ],
];

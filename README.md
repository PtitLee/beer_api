# Beer Api 

Tu trouveras les consignes sur https://follow-health.notion.site/Test-Backend-Developer-9d166619cde74d9293e5e6c4da63760a


# Installation

    make setup
    make vendor
    make bash

Une fois sur le container

    bin/console doctrine:migration:migrate
    bin/console import:csv
    
Les différentes api demandé:

- La/les bière(s) avec le meilleur score: `/api/beers/evalRanking`
- La/les bière(s) la/les plus amère(s) (IBU): `/api/beers/bitterRanking`
- Classement des pays, par nombre de brasseries décroissant: `/api/brewery/countryRanking`
- Classement des styles de bières par nombre de références décroissant: `/api/beerStyles/ranking`
- Classement des bières par taux d’alcool décroissant: `/api/beers/alcoholRanking`
 

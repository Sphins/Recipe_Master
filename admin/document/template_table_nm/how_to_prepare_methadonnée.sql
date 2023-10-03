ALTER TABLE tableDeNm COMMENT = '{
    "type": "nm",
    "junctionTable": "tableDeNm",
    "tables": {
        "from": {
            "name": "tableOrigine",
            "column": "nom de la colone origine",
            "displayInForm": true 
        },
        "to": {
            "name": "table d arriver",
            "column": "nom de la colone arriver",
            "displayInForm": false
        }
    }
}';


//si il y a des colonne suplementaire faire comme suit 

ALTER TABLE tableDeNm COMMENT = '{
    "type": "nm",
    "junctionTable": "tableDeNm",
    "tables": {
        "from": {
            "name": "tableOrigine",
            "column": "nom de la colone origine",
            "displayInForm": true 
        },
        "to": {
            "name": "table d arriver",
            "column": "nom de la colone arriver",
            "displayInForm": false
        }
    },
    "additionalColumns": [
        {
            "name": "quantity",
            "type": "float",
            "default": null,
            "required": false,
            "displayInForm": true
        },
        {
            "name": "anotherColumn",
            "type": "varchar",
            "default": "",
            "required": false,
            "displayInForm": true
        }
    ]
}';
ALTER TABLE books_has_tags COMMENT = '{
    "type": "nm",
    "junctionTable": "books_has_tags",
    "tables": {
        "from": {
            "name": "books",
            "column": "book_id",
            "displayInForm": true
        },
        "to": {
            "name": "tags",
            "column": "tag_id",
            "displayInForm": false
        }
    }
}';

ALTER TABLE users_collections COMMENT = '{
    "type": "nm",
    "junctionTable": "users_collections",
    "tables": {
        "from": {
            "name": "users",
            "column": "user_id",
            "displayInForm": false
        },
        "to": {
            "name": "books",
            "column": "book_id",
            "displayInForm": false
        }
    }
}';

ALTER TABLE users_notations COMMENT = '{
    "type": "nm",
    "junctionTable": "users_notations",
    "tables": {
        "from": {
            "name": "users",
            "column": "user_id",
            "displayInForm": false
        },
        "to": {
            "name": "books",
            "column": "book_id",
            "displayInForm": false
        }
    }
}';
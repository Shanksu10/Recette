<?php

namespace App\Repositories;

class Data
{
    public function users()
    {
        return [
            ["id" => 2, "first_name" => "Younes", "last_name" => "DJ", "email" => "younes@gmail.com", "password" => "a211f3e23a4v5c6r7e9", "birthday" => "1993-02-22"],
            ["id" => 3, "first_name" => "Oumaima", "last_name" => "KM", "email" => "oumaima@gmail.com", "password" => "f3ea4vaa5c126r7ez", "birthday" => "1988-10-22"],
            ["id" => 4, "first_name" => "Karim", "last_name" => "NO", "email" => "karim@gmail.com", "password" =>"qea4v5c6r7ez119", "birthday" => "1978-07-05"],
            ["id" => 5, "first_name" => "Noël", "last_name" => "Novelli", "email" => "noel@gmail.com", "password" => "mnkf3ea4v5c0981", "birthday" => "2000-01-01"],
            ["id" => 6, "first_name" => "Jean-Luc", "last_name" => "Mari", "email" => "jean-luc@gmail.com", "password" => "3ea4v5hgfr109", "birthday" => "1980-02-28"],
            ["id" => 7, "first_name" => "Riadh", "last_name" => "BEN", "email" => "riadh@gmail.com", "password" => "pty7w6a5a929", "birthday" => "1990-03-11"],
            ["id" => 8, "first_name" => "Antoine", "last_name" => "RM", "email" => "antoine@gmail.com", "password" => "2f3ea7ez8aanmbhy7809", "birthday" => "1999-12-01"],
            ["id" => 9, "first_name" => "Lara", "last_name" => "Clara", "email" => "lara-clara@gmail.com", "password" => "1nbx09hga40aqcx", "birthday" => "1995-10-17"],
            ["id" => 10, "first_name" => "Camille", "last_name" => "Duppond", "email" => "camille@gmail.com", "password" => "a2f322v5c6r7ekjd", "birthday" => "1998-12-12"],
            ["id" => 11, "first_name" => "Zakari", "last_name" => "CH", "email" => "zakaria@gmail.com", "password" => "azpmgdf1503c6r7ez8a9", "birthday" => "1989-08-09"],
            ["id" => 12, "first_name" => "Islam", "last_name" => "Chahid", "email" => "islam@gmail.com", "password" => "pq224v5c6r7ez8a9", "birthday" => "1983-07-30"],
            ["id" => 13, "first_name" => "Nathan", "last_name" => "Coppe", "email" => "nathan@gmail.com", "password" => "oi4p5625c6r7ez8a9", "birthday" => "1992-03-20"],
            ["id" => 14, "first_name" => "Amine", "last_name" => "Bel", "email" => "amine@gmail.com", "password" => "hdfa4v5c6r7ez8a90gf1", "birthday" => "2001-06-13"],
            ["id" => 15, "first_name" => "Bob", "last_name" => "Toto", "email" => "bob_toto@gmail.com", "password" => "ojysgcle1905gsf56", "birthday" => "1994-05-03"]

        ];
    }

    public function recipes()
    {
        return [
            [
                'id' => 1,
                'name' => 'buratta',
                'user_id' => 2,
                'description_recipe' => "Burrata est un fromage italien frais à base de mozzarella et de crème.",
                'preparation_steps' => "1. Mélanger les ingrédients dans un grand bol. 2. Mélanger jusqu'à ce qu'ils soient bien combinés. 3. Servir avec du pain ou des craquelins.",
                'preparation_time' => 20,
                'cooking_time' => 10,
                'type_recipe' => 'entrée',
                'number_per' => 4
            ],
            [
                'id' => 2,
                'name' => 'lasagna',
                'user_id' => 2,
                'description_recipe' => "La lasagne est un type de pâtes faites de feuilles plates et larges recouvertes de sauce et de fromage.",
                'preparation_steps' => "1. Préchauffer le four à 375°F. 2. Faites bouillir les pâtes à lasagne pendant 10 minutes. 3. Dans une autre poêle, dorer le boeuf haché. 4. Dans une autre casserole, préparez la sauce tomate. 5. Étalez les nouilles, la sauce et le fromage dans un plat allant au four de 9 x 13 pouces. 6. Cuire au four pendant 25-30 minutes ou jusqu\'à ce que le fromage soit fondu et bouillonne.",
                'preparation_time' => 30,
                'cooking_time' => 25,
                'type_recipe' => 'plat principal',
                'number_per' => 8
            ],
            [
                'id' => 3,
                'name' => 'Muffins poires',
                'user_id' => 3,
                'description_recipe' => 'Muffins poires et pépites de chocolat Nestlé Dessert.',
                'preparation_steps' => '1. Préchauffez votre four Th.7 (200°C). 2. Faites fondre le beurre dans un bol au four à micro-ondes. 3. Dans un saladier, mélangez les oeufs, le sucre, la farine et le beurre.',
                'preparation_time' => 30,
                'cooking_time' => 25,
                'type_recipe' => 'plat principal',
                'number_per' => 8
            ]
        ];
    }


    public function ingredients()
    {
        return [
            ['name_ingredient' => 'oeuf', 'nutri_value' => 60, 'unit' => 'portion'],
            ['name_ingredient' => 'viande hachée', 'nutri_value' => 120, 'unit' => 'gramme'],
            ['name_ingredient' => 'lait', 'nutri_value' => 42, 'unit' => 'litre'],
            ['name_ingredient' => 'farine', 'nutri_value' => 365, 'unit' => 'gramme'],
            ['name_ingredient' => 'sucre', 'nutri_value' => 387, 'unit' => 'gramme'],
            ['name_ingredient' => 'sel', 'nutri_value' => 0, 'unit' => 'gramme'],
            ['name_ingredient' => 'huile d\'olive', 'nutri_value' => 884, 'unit' => 'litre'],
            ['name_ingredient' => 'poivre', 'nutri_value' => 0, 'unit' => 'gramme']
        ];
    }

    public function meals()
    {
        return [
            ['name_meal' => 'noel chez les grenoblois', 'user_id' => 2],
            ['name_meal' => 'noel chez les parisien', 'user_id' => 2],
            ['name_meal' => 'bowl', 'user_id' => 2],
            ['name_meal' => 'tajine', 'user_id' => 3]
        ];
    }

    public function comments()
    {
        return [
            ['id' => 1,'comment' => 'Great post!', 'date_comment' => '2023-02-08 12:00:00'],
            ['id' => 2,'comment' => 'I agree with you.', 'date_comment' => '2023-02-08 13:00:00'],
            ['id' => 3,'comment' => 'Thanks for sharing your thoughts.', 'date_comment' => '2023-02-08 14:00:00']
        ];
    }


    public function category_recipes()
    {
        return [
                ['name_category_recipe'=> 'Cuisine italienne'],
                ['name_category_recipe'=>'Cuisine française'],
                ['name_category_recipe'=>'Cuisine asiatique'],
                ['name_category_recipe'=>'Cuisine orientale']
        ];
    }

    public function categories_of_recipes()
    {
        return [
            ['recipe_id' => 1, 'category_recipe_id'=> '1'],
            ['recipe_id' => 2, 'category_recipe_id'=> '2'],
            ['recipe_id' => 3, 'category_recipe_id'=> '3'],
            ['recipe_id' => 3, 'category_recipe_id'=> '4'],
        ];
    }

    public function category_meals()
    {
        return [
            ['name_category_meal' => 'plat du jour'],
            ['name_category_meal' => 'plat Noel'],
            ['name_category_meal' => 'plat healthy']
        ];
    }


    public function marks()
    {
        return [
            ['user_id' => 2, 'recipe_id' => 1, 'mark' => 4.5],
            ['user_id' => 2, 'recipe_id' => 2, 'mark' => 4.0],
            ['user_id' => 3, 'recipe_id' => 3, 'mark' => 3.5],
            ['user_id' => 2, 'recipe_id' => 3, 'mark' => 5.0]
        ];
    }

    public function recipe_commented_by_user()
    {
        return [
            ['comment_id' => 1,'user_id' => 3, 'recipe_id' => 1],
            ['comment_id' => 2,'user_id' => 2, 'recipe_id' => 2],
            ['comment_id' => 3,'user_id' => 3, 'recipe_id' => 2]
        ];
    }

    public function recipe_ingredients()
    {
        return [
              ['recipe_id' => 1,'ingredient_id' => 1,'quantity_ingredient' => 4.0],
              ['recipe_id' => 1,'ingredient_id' => 2,'quantity_ingredient' => 500.0],
              ['recipe_id' => 3,'ingredient_id' => 2,'quantity_ingredient' => 100.0],
              ['recipe_id' => 3,'ingredient_id' => 3,'quantity_ingredient' => 200.0],
              ['recipe_id' => 3,'ingredient_id' => 1,'quantity_ingredient' => 2.0],
              ['recipe_id' => 2,'ingredient_id' => 1,'quantity_ingredient' => 200.0],
              ['recipe_id' => 2,'ingredient_id' => 2,'quantity_ingredient' => 50.0],
              ['recipe_id' => 2,'ingredient_id' => 4,'quantity_ingredient' => 30.0]
        ];
    }

    public function favorites()
    {
        return [
            ['user_id' => 2, 'recipe_id' => 1],
            ['user_id' => 2, 'recipe_id' => 2],
            ['user_id' => 3, 'recipe_id' => 3],
            ['user_id' => 3, 'recipe_id' => 1]
        ];
    }

    public function categories_of_meals()
    {
        return [
            ["meal_id" =>1, "category_meal_id" => 3],
            ["meal_id" =>2, "category_meal_id" => 3],
            ["meal_id" =>3, "category_meal_id" => 1],
            ["meal_id" =>4, "category_meal_id" => 3],
            ["meal_id" =>3, "category_meal_id" => 2]
        ];
    }

    public function recipes_of_meal()
    {
        return [
            ["meal_id" => 1, "recipe_id" =>1],
            ["meal_id" => 1, "recipe_id" =>2],
            ["meal_id" => 1, "recipe_id" =>3],
            ["meal_id" => 2, "recipe_id" =>3],
            ["meal_id" => 2, "recipe_id" =>2],
            ["meal_id" => 2, "recipe_id" =>1]
        ];
    }
}

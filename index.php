<?php

/**
 * Build nested tree structure from
 * simple array which contain parent child relation
 *
 * @param  array  $items  Array which contain simple flat structure
 * @param  string  $childFieldName  Name of field which append objects as childs
 * @param  string  $parentFieldName  Name of field which point to parent object
 * @param string $idName  Name of field which contain identity id
 * 
 * @return array $tree  Tree hierarchy with single or multiple root
 */
function buildTree(
    array $items,
    string $childFieldName = 'childs',
    string $parentFieldName = 'parent_id',
    string $idName  = 'id'
): array {

    // Initialize tree array
    $tree = [];

    // Iterate over each object and 
    // organize all which shares same parent id with reference
    foreach ($items as &$item) {

        $tree[$item[$parentFieldName]][] = &$item;
    }

    unset($item);

    // Iterate over each object and check 
    // if their child exist in tree then 
    // append all childs
    foreach ($items as &$item) {

        $item[$childFieldName] = [];

        if (isset($tree[$item[$idName]])) {

            $item[$childFieldName] = $tree[$item[$idName]];
            unset($tree[$item[$idName]]);
        }
    }
     
    // check if tree has multiple root
    if (count($tree) === 1) {

        // return tree with single root
        return array_pop($tree);
    }

    // return tree with multiple root
    return $tree;
}

$rawarr = [
    [
      "id" => 8,
      "parent" => 4,
      "name" => "Food & Lifestyle"
    ],
    [
      "id" => 2,
      "parent" => 1,
      "name" => "Mobile Phones"
    ],
    [
      "id" => 1,
      "parent" => 0,
      "name" => "Electronics"
    ],
    [
      "id" => 3,
      "parent" => 1,
      "name" => "Laptops"
    ],
    [
      "id" => 5,
      "parent" => 4,
      "name" => "Fiction"
    ],
    [
      "id" => 4,
      "parent" => 0,
      "name" => "Books"
    ],
    [
      "id" => 6,
      "parent" => 4,
      "name" => "Non-fiction"
    ],
    [
      "id" => 7,
      "parent" => 1,
      "name" => "Storage"
    ]
];

$output = buildTree($rawarr, 'children', 'parent');

print("<pre>".print_r($output,true)."</pre>");

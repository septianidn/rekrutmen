<?php
/**
 * Generates a StarUML (.mdj) file containing the Pusat Karir ERD.
 *
 * Usage:
 *   php docs/generate_staruml_mdj.php
 *
 * Output:
 *   docs/PusatKarir.mdj   (open in StarUML via File > Open)
 *
 * After opening: the data model and all entities + relationships are loaded.
 * To see them visually, right-click the ERDDataModel in the Model Explorer
 * and choose "Add Diagram > ERD Diagram", then drag entities onto the canvas
 * (or use "Auto Layout").
 *
 * Schema is defined in docs/_schema.php.
 */

$schema        = require __DIR__ . '/_schema.php';
$entities      = $schema['entities'];
$relationships = $schema['relationships'];

$projectId   = 'AAA-project';
$modelId     = 'AAA-model';
$dataModelId = 'AAA-datamodel';

$entityNodes = [];
$columnIndex = []; // [table][column] => column _id

foreach ($entities as $table => $cols) {
    $entId   = 'ent-' . $table;
    $columns = [];

    foreach ($cols as $col) {
        $name   = $col[0];
        $type   = $col[1];
        $length = $col[2] ?? null;
        $flags  = array_slice($col, 3);

        $colId = 'col-' . $table . '-' . $name;
        $columnIndex[$table][$name] = $colId;

        $column = [
            '_type'      => 'ERDColumn',
            '_id'        => $colId,
            '_parent'    => ['$ref' => $entId],
            'name'       => $name,
            'type'       => $type,
            'nullable'   => in_array('null', $flags, true),
            'primaryKey' => in_array('pk',   $flags, true),
            'foreignKey' => in_array('fk',   $flags, true),
            'unique'     => in_array('uk',   $flags, true),
        ];
        if ($length !== null) {
            $column['length'] = (int) $length;
        }
        $columns[] = $column;
    }

    $entityNodes[] = [
        '_type'   => 'ERDEntity',
        '_id'     => $entId,
        '_parent' => ['$ref' => $dataModelId],
        'name'    => $table,
        'columns' => $columns,
    ];
}

$relationshipNodes = [];
$i = 0;
foreach ($relationships as $rel) {
    [$childTable, $childCol, $parentTable, $parentCol] = $rel;
    $i++;
    $relId = 'rel-' . $i;

    $childColId  = $columnIndex[$childTable][$childCol] ?? null;
    $parentColId = $columnIndex[$parentTable][$parentCol] ?? null;
    if ($childColId && $parentColId) {
        foreach ($entityNodes as &$ent) {
            if ($ent['name'] === $childTable) {
                foreach ($ent['columns'] as &$c) {
                    if ($c['name'] === $childCol) {
                        $c['referenceTo'] = ['$ref' => $parentColId];
                    }
                }
                unset($c);
            }
        }
        unset($ent);
    }

    $relationshipNodes[] = [
        '_type'       => 'ERDRelationship',
        '_id'         => $relId,
        '_parent'     => ['$ref' => $dataModelId],
        'name'        => $childTable . '_' . $childCol . '_fk',
        'end1'        => [
            '_type'       => 'ERDRelationshipEnd',
            '_id'         => $relId . '-e1',
            '_parent'     => ['$ref' => $relId],
            'reference'   => ['$ref' => 'ent-' . $childTable],
            'cardinality' => '0..*',
        ],
        'end2'        => [
            '_type'       => 'ERDRelationshipEnd',
            '_id'         => $relId . '-e2',
            '_parent'     => ['$ref' => $relId],
            'reference'   => ['$ref' => 'ent-' . $parentTable],
            'cardinality' => '1',
        ],
        'identifying' => false,
    ];
}

$doc = [
    '_type'         => 'Project',
    '_id'           => $projectId,
    'name'          => 'PusatKarir',
    'author'        => 'Generated from Laravel migrations',
    'ownedElements' => [[
        '_type'         => 'UMLModel',
        '_id'           => $modelId,
        '_parent'       => ['$ref' => $projectId],
        'name'          => 'Model',
        'ownedElements' => [[
            '_type'         => 'ERDDataModel',
            '_id'           => $dataModelId,
            '_parent'       => ['$ref' => $modelId],
            'name'          => 'PusatKarir Schema',
            'ownedElements' => array_merge($entityNodes, $relationshipNodes),
        ]],
    ]],
];

$out = __DIR__ . '/PusatKarir.mdj';
file_put_contents(
    $out,
    json_encode($doc, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
);

echo "Wrote: $out\n";
echo 'Entities: ' . count($entityNodes) . "\n";
echo 'Relationships: ' . count($relationshipNodes) . "\n";

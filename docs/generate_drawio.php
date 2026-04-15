<?php
/**
 * Generates a draw.io (.drawio) file containing the Pusat Karir ERD.
 *
 * Usage:
 *   php docs/generate_drawio.php
 *
 * Output:
 *   docs/PusatKarir.drawio
 *
 * Open with app.diagrams.net, the VS Code "Draw.io Integration" extension,
 * or the desktop app. After opening, right-click empty canvas > "Layout"
 * (or Arrange > Layout > ...) for cleaner positioning.
 *
 * Schema is defined in docs/_schema.php.
 */

$schema        = require __DIR__ . '/_schema.php';
$entities      = $schema['entities'];
$relationships = $schema['relationships'];

/* ---- layout parameters ---- */
$tableWidth   = 260;
$headerHeight = 30;
$rowHeight    = 24;
$keyColWidth  = 40;
$columnsInGrid = 5;
$gridGapX     = 60;
$gridGapY     = 50;

/* ---- build cells ---- */
$cells = [];
$cells[] = '<mxCell id="0" />';
$cells[] = '<mxCell id="1" parent="0" />';

$colIndex = 0;
$colY     = array_fill(0, $columnsInGrid, 40);

$columnCellIds = []; // [table][column] => row cell id (used as edge endpoints)

$tableStyle = 'shape=table;startSize=30;container=1;collapsible=0;childLayout=tableLayout;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;fontStyle=1;';
$rowStyle   = 'shape=tableRow;horizontal=0;startSize=0;swimlaneHead=0;swimlaneBody=0;strokeColor=inherit;top=0;left=0;bottom=0;right=0;collapsible=0;dropTarget=0;fillColor=none;points=[[0,0.5],[1,0.5]];portConstraint=eastwest;fontSize=12;';
$keyCellStyle  = 'shape=partialRectangle;overflow=hidden;connectable=0;fillColor=none;top=0;left=0;bottom=0;right=0;pointerEvents=1;fontSize=11;fontStyle=1;';
$nameCellStyle = 'shape=partialRectangle;overflow=hidden;connectable=0;fillColor=none;top=0;left=0;bottom=0;right=0;pointerEvents=1;fontSize=12;align=left;spacingLeft=6;';

foreach ($entities as $table => $cols) {
    $col = $colIndex % $columnsInGrid;
    $x   = 40 + $col * ($tableWidth + $gridGapX);
    $y   = $colY[$col];
    $h   = $headerHeight + count($cols) * $rowHeight;

    $tableId = 't_' . $table;
    $cells[] = sprintf(
        '<mxCell id="%s" value="%s" style="%s" vertex="1" parent="1"><mxGeometry x="%d" y="%d" width="%d" height="%d" as="geometry"/></mxCell>',
        htmlspecialchars($tableId, ENT_XML1),
        htmlspecialchars($table, ENT_XML1),
        $tableStyle,
        $x, $y, $tableWidth, $h
    );

    $rowY = $headerHeight;
    foreach ($cols as $c) {
        $name   = $c[0];
        $type   = $c[1];
        $length = $c[2] ?? null;
        $flags  = array_slice($c, 3);

        $isPk   = in_array('pk',   $flags, true);
        $isFk   = in_array('fk',   $flags, true);
        $isUk   = in_array('uk',   $flags, true);
        $isNull = in_array('null', $flags, true);

        $keyLabel = $isPk ? 'PK' : ($isFk ? 'FK' : ($isUk ? 'UK' : ''));
        $typeLabel = $length !== null ? "$type($length)" : $type;
        $nullable  = $isNull ? ' NULL' : '';
        $label     = "$name : $typeLabel$nullable";

        $rowId = 'r_' . $table . '_' . $name;
        $columnCellIds[$table][$name] = $rowId;

        $cells[] = sprintf(
            '<mxCell id="%s" value="" style="%s" vertex="1" parent="%s"><mxGeometry y="%d" width="%d" height="%d" as="geometry"/></mxCell>',
            htmlspecialchars($rowId, ENT_XML1),
            $rowStyle,
            htmlspecialchars($tableId, ENT_XML1),
            $rowY, $tableWidth, $rowHeight
        );

        $cells[] = sprintf(
            '<mxCell id="%s" value="%s" style="%s" vertex="1" parent="%s"><mxGeometry width="%d" height="%d" as="geometry"/></mxCell>',
            htmlspecialchars($rowId . '_k', ENT_XML1),
            htmlspecialchars($keyLabel, ENT_XML1),
            $keyCellStyle,
            htmlspecialchars($rowId, ENT_XML1),
            $keyColWidth, $rowHeight
        );

        $cells[] = sprintf(
            '<mxCell id="%s" value="%s" style="%s" vertex="1" parent="%s"><mxGeometry x="%d" width="%d" height="%d" as="geometry"/></mxCell>',
            htmlspecialchars($rowId . '_n', ENT_XML1),
            htmlspecialchars($label, ENT_XML1),
            $nameCellStyle,
            htmlspecialchars($rowId, ENT_XML1),
            $keyColWidth, $tableWidth - $keyColWidth, $rowHeight
        );

        $rowY += $rowHeight;
    }

    $colY[$col] = $y + $h + $gridGapY;
    $colIndex++;
}

/* ---- edges ---- */
$edgeStyle = 'edgeStyle=entityRelationEdgeStyle;fontSize=12;html=1;endArrow=ERone;startArrow=ERmany;rounded=0;exitX=1;exitY=0.5;exitDx=0;exitDy=0;entryX=0;entryY=0.5;entryDx=0;entryDy=0;';

$i = 0;
foreach ($relationships as $rel) {
    [$childTable, $childCol, $parentTable, $parentCol] = $rel;
    $i++;
    $source = $columnCellIds[$childTable][$childCol]  ?? null;
    $target = $columnCellIds[$parentTable][$parentCol] ?? null;
    if (!$source || !$target) continue;

    $cells[] = sprintf(
        '<mxCell id="e_%d" style="%s" edge="1" parent="1" source="%s" target="%s"><mxGeometry relative="1" as="geometry"/></mxCell>',
        $i,
        $edgeStyle,
        htmlspecialchars($source, ENT_XML1),
        htmlspecialchars($target, ENT_XML1)
    );
}

/* ---- wrap document ---- */
$pageWidth  = 40 + $columnsInGrid * ($tableWidth + $gridGapX);
$pageHeight = max($colY) + 100;

$modified = gmdate('Y-m-d\TH:i:s\Z');

$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= sprintf(
    '<mxfile host="app.diagrams.net" modified="%s" agent="pusatkarir-generator" version="22.0.0" type="device">' . "\n",
    $modified
);
$xml .= '  <diagram id="pusatkarir-erd" name="PusatKarir ERD">' . "\n";
$xml .= sprintf(
    '    <mxGraphModel dx="%d" dy="%d" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="%d" pageHeight="%d" math="0" shadow="0">' . "\n",
    $pageWidth, $pageHeight, $pageWidth, $pageHeight
);
$xml .= '      <root>' . "\n";
foreach ($cells as $c) {
    $xml .= '        ' . $c . "\n";
}
$xml .= '      </root>' . "\n";
$xml .= '    </mxGraphModel>' . "\n";
$xml .= '  </diagram>' . "\n";
$xml .= '</mxfile>' . "\n";

$out = __DIR__ . '/PusatKarir.drawio';
file_put_contents($out, $xml);

echo "Wrote: $out\n";
echo 'Entities: ' . count($entities) . "\n";
echo 'Relationships: ' . count($relationships) . "\n";

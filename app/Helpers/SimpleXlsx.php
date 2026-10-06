<?php

namespace App\Helpers;

class SimpleXlsx
{
    private $sheets = [];
    private $sharedStrings = [];
    private $sharedStringsIndex = [];

    public function addSheet(string $name, array $rows, array $headers = [], array $options = [])
    {
        $this->sheets[] = [
            'name'    => $name,
            'headers' => $headers,
            'rows'    => $rows,
            'title'   => $options['title']   ?? '',
            'summary' => $options['summary'] ?? '',
        ];
    }

    private function esc(string $v): string
    {
        return htmlspecialchars($v, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private function getSSI(string $value): int
    {
        if (isset($this->sharedStringsIndex[$value])) {
            return $this->sharedStringsIndex[$value];
        }
        $idx = count($this->sharedStrings);
        $this->sharedStrings[]            = $value;
        $this->sharedStringsIndex[$value] = $idx;
        return $idx;
    }

    private function col(int $n): string
    {
        $l = '';
        while ($n >= 0) {
            $l = chr(65 + ($n % 26)) . $l;
            $n = intdiv($n, 26) - 1;
        }
        return $l;
    }

    private function contentTypes(): string
    {
        $ov = '';
        foreach ($this->sheets as $i => $s) {
            $ov .= '<Override PartName="/xl/worksheets/sheet'.($i+1).'.xml" '
                 . 'ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
        }
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
<Default Extension="xml"  ContentType="application/xml"/>
<Override PartName="/xl/workbook.xml"      ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
<Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
<Override PartName="/xl/styles.xml"        ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
'.$ov.'</Types>';
    }

    private function rels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>';
    }

    private function workbookRels(): string
    {
        $r = '';
        foreach ($this->sheets as $i => $s) {
            $r .= '<Relationship Id="rId'.($i+1).'" '
                . 'Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" '
                . 'Target="worksheets/sheet'.($i+1).'.xml"/>';
        }
        $si = count($this->sheets) + 1;
        $ss = count($this->sheets) + 2;
        $r .= '<Relationship Id="rId'.$si.'" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles"        Target="styles.xml"/>';
        $r .= '<Relationship Id="rId'.$ss.'" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>';
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'.$r.'</Relationships>';
    }

    private function workbook(): string
    {
        $s = '';
        foreach ($this->sheets as $i => $sh) {
            $s .= '<sheet name="'.$this->esc($sh['name']).'" sheetId="'.($i+1).'" r:id="rId'.($i+1).'"/>';
        }
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
          xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
<sheets>'.$s.'</sheets>
</workbook>';
    }

    private function styles(): string
    {
       
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="5">
    <font><sz val="11"/><name val="Arial"/></font>
    <font><b/><sz val="11"/><name val="Arial"/><color rgb="FFFFFFFF"/></font>
    <font><b/><sz val="13"/><name val="Arial"/><color rgb="FFFFFFFF"/></font>
    <font><b/><sz val="11"/><name val="Arial"/><color rgb="FF029B69"/></font>
    <font><sz val="11"/><name val="Arial"/></font>
  </fonts>
  <fills count="5">
    <fill><patternFill patternType="none"/></fill>
    <fill><patternFill patternType="gray125"/></fill>
    <fill><patternFill patternType="solid"><fgColor rgb="FF2D6A4F"/></patternFill></fill>
    <fill><patternFill patternType="solid"><fgColor rgb="FF029B69"/></patternFill></fill>
    <fill><patternFill patternType="solid"><fgColor rgb="FFF0FDF4"/></patternFill></fill>
  </fills>
  <borders count="2">
    <border><left/><right/><top/><bottom/><diagonal/></border>
    <border>
      <left   style="thin"><color rgb="FFCCCCCC"/></left>
      <right  style="thin"><color rgb="FFCCCCCC"/></right>
      <top    style="thin"><color rgb="FFCCCCCC"/></top>
      <bottom style="thin"><color rgb="FFCCCCCC"/></bottom>
    </border>
  </borders>
  <cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>
  <cellXfs count="6">
    <xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"><alignment vertical="center"/></xf>
    <xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>
    <xf numFmtId="0" fontId="2" fillId="3" borderId="0" xfId="0"><alignment horizontal="center" vertical="center"/></xf>
    <xf numFmtId="0" fontId="4" fillId="4" borderId="1" xfId="0"><alignment vertical="center"/></xf>
    <xf numFmtId="0" fontId="3" fillId="0" borderId="0" xfId="0"><alignment horizontal="right" vertical="center"/></xf>
    <xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"><alignment horizontal="center" vertical="center"/></xf>
  </cellXfs>
</styleSheet>';
    }

    private function sharedStringsXml(): string
    {
        $total = count($this->sharedStrings);
        $items = '';
        foreach ($this->sharedStrings as $str) {
            $items .= '<si><t xml:space="preserve">'.$this->esc((string)$str).'</t></si>';
        }
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="'.$total.'" uniqueCount="'.$total.'">'.$items.'</sst>';
    }

    private function buildSheet(array $def): string
    {
        $headers  = $def['headers'];
        $rows     = $def['rows'];
        $colCount = max(count($headers), isset($rows[0]) ? count($rows[0]) : 0, 1);

        $widths  = [5,14,22,18,18,10,10,12,15,22,25,14,12,12,10];
        $colDefs = '<cols>';
        for ($c = 0; $c < $colCount; $c++) {
            $w = $widths[$c] ?? 14;
            $colDefs .= '<col min="'.($c+1).'" max="'.($c+1).'" width="'.$w.'" customWidth="1"/>';
        }
        $colDefs .= '</cols>';

        $xml    = '';
        $rowIdx = 1;
        $lastC  = $this->col($colCount - 1);

        // ── Title row ─────────────────────────────────────────
        if (!empty($def['title'])) {
            $si   = $this->getSSI($def['title']);
            $xml .= '<row r="'.$rowIdx.'" ht="28" customHeight="1">';
            $xml .= '<c r="A'.$rowIdx.'" t="s" s="2"><v>'.$si.'</v></c>';
            for ($c = 1; $c < $colCount; $c++) {
                $xml .= '<c r="'.$this->col($c).$rowIdx.'" s="2"/>';
            }
            $xml .= '</row>';
            $rowIdx++;
        }

        // ── Header row ────────────────────────────────────────
        if (!empty($headers)) {
            $xml .= '<row r="'.$rowIdx.'" ht="20" customHeight="1">';
            foreach ($headers as $c => $h) {
                $si   = $this->getSSI((string)$h);
                $xml .= '<c r="'.$this->col($c).$rowIdx.'" t="s" s="1"><v>'.$si.'</v></c>';
            }
            $xml .= '</row>';
            $rowIdx++;
        }

        // ── Data rows ─────────────────────────────────────────
        foreach ($rows as $rn => $row) {
            $style = ($rn % 2 === 1) ? 3 : 0;
            $xml  .= '<row r="'.$rowIdx.'" ht="18" customHeight="1">';
            foreach ($row as $c => $val) {
                $ref = $this->col($c).$rowIdx;
                $cs  = ($c === 0) ? 5 : $style;
                $val = ($val === null) ? '' : $val;
                if (is_numeric($val) && !is_string($val)) {
                    $xml .= '<c r="'.$ref.'" s="'.$cs.'"><v>'.$val.'</v></c>';
                } else {
                    $si  = $this->getSSI((string)$val);
                    $xml .= '<c r="'.$ref.'" t="s" s="'.$cs.'"><v>'.$si.'</v></c>';
                }
            }
            $xml .= '</row>';
            $rowIdx++;
        }

        // ── Summary row ───────────────────────────────────────
        if (!empty($def['summary'])) {
            $si   = $this->getSSI($def['summary']);
            $xml .= '<row r="'.$rowIdx.'" ht="18" customHeight="1">';
            $xml .= '<c r="A'.$rowIdx.'" t="s" s="4"><v>'.$si.'</v></c>';
            $xml .= '</row>';
        }

        // Merge title row
        $merge = '';
        if (!empty($def['title'])) {
            $merge = '<mergeCells count="1"><mergeCell ref="A1:'.$lastC.'1"/></mergeCells>';
        }

        // Freeze pane below headers
        $freeze = empty($def['title']) ? 2 : 3;
        $view   = '<sheetViews><sheetView tabSelected="1" workbookViewId="0">
<pane ySplit="'.($freeze-1).'" topLeftCell="A'.$freeze.'" activePane="bottomLeft" state="frozen"/>
</sheetView></sheetViews>';

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
           xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
'.$view.'
'.$colDefs.'
<sheetData>'.$xml.'</sheetData>
'.$merge.'
</worksheet>';
    }

    public function generate(): string
    {
        $this->sharedStrings      = [];
        $this->sharedStringsIndex = [];

        $sheetXmls = [];
        foreach ($this->sheets as $def) {
            $sheetXmls[] = $this->buildSheet($def);
        }

        $tmp = tempnam(sys_get_temp_dir(), 'xlsx_');
        if (file_exists($tmp)) unlink($tmp);
        $tmp .= '.xlsx';

        $zip = new \ZipArchive();
        if ($zip->open($tmp, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('ZipArchive open failed — check server temp dir permissions');
        }

        $zip->addFromString('_rels/.rels',                $this->rels());
        $zip->addFromString('[Content_Types].xml',        $this->contentTypes());
        $zip->addFromString('xl/workbook.xml',            $this->workbook());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRels());
        $zip->addFromString('xl/styles.xml',              $this->styles());
        $zip->addFromString('xl/sharedStrings.xml',       $this->sharedStringsXml());

        foreach ($sheetXmls as $i => $xml) {
            $zip->addFromString('xl/worksheets/sheet'.($i+1).'.xml', $xml);
        }

        $zip->close();

        $content = file_get_contents($tmp);
        unlink($tmp);
        return $content;
    }

    public function download(string $filename): \Illuminate\Http\Response
    {
        $content = $this->generate();
        return response($content, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control'       => 'max-age=0',
            'Content-Length'      => strlen($content),
        ]);
    }
}

<?php
namespace Appsas;

class DuomanuIsvedimas
{

    public function isvestiAsmenis($asmenys)
    {
        /** @var Asmuo $asmuo */
        foreach ($asmenys as $asmuo) {
            echo 'Asmuo: '. $asmuo->getVardas() . ' Amžius: '. $asmuo->getAmzius().' metai<br>';
        }
    }

    public function isvestiAsmenisPagalData($asmenys, $gmmd)
    {
        /** @var Asmuo $asmuo */
        foreach ($asmenys as $asmuo) {
            if ($asmuo->getGimimoData()->format('Y') == $gmmd) {
                echo 'Asmuo: '. $asmuo->getVardas() . ' Amžius: '. $asmuo->getAmzius().' metai<br>';
            }
        }
    }

    public function isvestiAsmenisLentele($asmenys)
    {
        echo '<table>';
        echo '<tr><th>Vardas</th><th>Amžius</th></tr>';
        /** @var Asmuo $asmuo */
        foreach ($asmenys as $asmuo) {
            echo '<tr><td>'. $asmuo->getVardas() . '</td><td>'. $asmuo->getAmzius().' metai</td></tr>';
        }
        echo '</table>';
    }
}
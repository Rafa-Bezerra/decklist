<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DecklistController extends Controller
{
    function liga() : array {
        return [
            'Edicao (PTBR)',
            'Edicao (EN)',
            'Edicao (Sigla)',
            'Card (PT)',
            'Card (EN)',
            'Quantidade',
            'Qualidade (M NM SP MP HP D)',
            'Idioma (BR EN DE ES FR IT JP KO RU TW)',
            'Raridade (M R U C)',
            'Cor (W U B R G M A L)',
            'Extras',
            'Card #',
            'Comentario'
        ];
        
    }

    function delver() : array {
        return [
            'Count',
            'Name',
            'Edition',
            'Condition',
            'Language',
            'Foil',
            'Collector Number'
        ];        
    }

    function decklist() : View {
        return view('decklist');
    }

    function convert(Request $request) {
        $origin = $request->input('origin');
        $destiny = $request->input('destiny');
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $output = array();
            
            switch ($origin) {
                case 'liga':
                    switch ($destiny) {
                        case 'moxfield': //TODO
                            $output = $this->liga_to_moxfield($data);
                            break;
                        case 'goldfish': //TODO
                            $output = $this->liga_to_goldfish($data);
                            break;
                        case 'delver': //TODO
                            $output = $this->liga_to_delver($data);
                            break;
                        default:
                            break;
                    }
                    break;
                case 'moxfield':
                    switch ($destiny) {
                        case 'liga': //TODO
                            $output = $this->moxfield_to_liga($data);
                            break;
                        case 'goldfish': //TODO
                            $output = $this->moxfield_to_goldfish($data);
                            break;
                        case 'delver': //TODO
                            $output = $this->moxfield_to_delver($data);
                            break;
                        default:
                            break;
                    }
                    break;
                case 'goldfish':
                    switch ($destiny) {
                        case 'liga': //TODO
                            $output = $this->goldfish_to_liga($data);
                            break;
                        case 'moxfield': //TODO
                            $output = $this->goldfish_to_moxfield($data);
                            break;
                        case 'delver': //TODO
                            $output = $this->goldfish_to_delver($data);
                            break;
                        default:
                            break;
                    }
                    break;
                case 'delver':
                    switch ($destiny) {
                        case 'liga':
                            $output = $this->delver_to_liga($data);
                            break;
                        case 'moxfield': //TODO
                            $output = $this->delver_to_moxfield($data);
                            break;
                        case 'goldfish': //TODO
                            $output = $this->delver_to_goldfish($data);
                            break;
                        default:
                            break;
                    }
                    break;
            }

            $content = array(
                'Content-Type: application/csv',
            );

            $converted = fopen('converted-decklist.csv', 'w');
            foreach ($output as $row) {
                fputcsv($converted, (array) $row);
            }
            fclose($converted);

            return response()->download(public_path('converted-decklist.csv'), 'converted-decklist.csv', $content)->deleteFileAfterSend(true);
        } else {
            return 'none';
        }

    }

    function delver_to_liga($data) : array {
        $output = array();
		$output[0] = $this->liga();
        foreach ($data as $key => $value) {
			if ($key != 0) {
				$line = [];
				// 'Edicao (PTBR)'
				$line[0] = '';
				// 'Edicao (EN)'
				$line[1] = '';
				// 'Edicao (Sigla)'
				switch ($value[2]) {
                    case 'unf':
                        $translate = 'BLUNF';
                        break;
                    case 'MPS':
                        $translate = 'MPSKLD';
                        break;
                    case 'PLST':
                        $translate = 'PLIST';
                        break;
                    case 'PF24':
                        $translate = 'MFPF24';
                        break;
                    case 'J16':
                        $translate = 'SLD222JP';
                        break;
                    case 'PNAT':
                        $translate = 'BLUNF';
                        break;
                    case 'PAKH':
                        $translate = 'BLUNF';
                        break;
                    case 'PHOU':
                        $translate = 'BLUNF';
                        break;
                    default:
                        $translate = $value[2];
                        break;
                }
                $line[2] = $translate;
				// 'Card (PT)'
				$line[3] = '';
				// 'Card (EN)'
				$line[4] = $value[1];
				// 'Quantidade'
				$line[5] = $value[0];
				// 'Qualidade (M NM SP MP HP D)'
				$line[6] = $value[3];
				// 'Idioma (BR EN DE ES FR IT JP KO RU TW)'
				$line[7] = $value[4];
				// 'Raridade (M R U C)'
				$line[8] = '';
				// 'Cor (W U B R G M A L)'
				$line[9] = '';
				// 'Extras'
				$line[10] = $value[5];
				// 'Card #'
				$line[11] = $value[6];
				// 'Comentario'
				$line[12] = '';
				$output[$key] = $line;
			}
		}

        return $output;
    }
}

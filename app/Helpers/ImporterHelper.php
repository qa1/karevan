<?php

namespace App\Helpers;

use App\Models\Person;
use Maatwebsite\Excel\Facades\Excel;

class ImporterHelper
{
    private $file;
    private $valid;
    private $invalid;
    private $isReset = false;

    public function __construct($file, $isReset)
    {
        $this->file    = $file;
        $this->valid   = collect();
        $this->invalid = collect();
        $this->isReset = $isReset;
    }

    private function process()
    {
        static $proceed = false;

        if ($proceed !== false) {
            return;
        }

        Excel::load($this->file, function ($reader) {
            
            foreach ($reader->get() as $Rows) {
                foreach ($Rows as $Cell) {
                    $Row = $Cell->all();

                    if (empty($Row['name']) || empty($Row['father']) || empty($Row['city']) || empty($Row['modir'])) {
                        $this->invalid->push(array_merge($Row, ['dalil' => 'تمام فیلد های اجباری پر نشده اند']));
                        continue;
                    }

                    /**
                     * Type code, melli Float miyad va ctype_digit dorost tashkhis nemide
                     */
                    if (!empty($Row['code']) && preg_match("/[^0-9]/", $Row['code'])) {
                        $this->invalid->push(array_merge($Row, ['dalil' => 'کد تردد فقط عدد باید باشد']));
                        continue;
                    }

                    if (!empty($Row['melli']) && preg_match("/[^0-9]/", $Row['melli'])) {
                        $this->invalid->push(array_merge($Row, ['dalil' => 'کد ملی فقط باید عدد باشد']));
                        continue;
                    }

                    // Unique Check
                    // Agar reset set shode dige tekrari boodan nabayad check beshe
                    if (!$this->isReset) {
                        if (!empty($Row['code'])) {
                            if (
                                Person::where('code', $Row['code'])->first() ||
                                $Rows->where('code', $Row['code'])->count() > 1
                            ) {
                                $this->invalid->push(array_merge($Row, ['dalil' => 'کد تردد تکراری است']));
                                // Goftan ke tekrari code sabt beshe!
                                continue;
                            }
                        }

                        if (!empty($Row['melli'])) {
                            if (
                                Person::where('melli', $Row['melli'])->first() ||
                                $Rows->where('melli', $Row['melli'])->count() > 1
                            ) {
                                $this->invalid->push(array_merge($Row, ['dalil' => 'کد ملی تکراری است']));
                                // Goftan ke tekrari code sabt beshe!
                                continue;
                            }
                        }
                    }

                    $this->valid->push($Row);

                }
            }

        });

        $proceed = true;
    }

    public function run()
    {
        $this->process();
        return [
            'valid'   => $this->valid,
            'invalid' => $this->invalid,
        ];
    }

}

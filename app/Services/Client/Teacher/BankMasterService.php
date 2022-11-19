<?php

declare(strict_types=1);

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Repositories\BankMasterRepository;
use App\Services\BaseService;
use Limelight\Limelight;

class BankMasterService extends BaseService
{
    /**
     * @var $bankMaster
     */
    private $bankMaster;

    /**
     * CourseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->bankMaster = app(BankMasterRepository::class);
    }

    /**
     * @return string
     */
    public function repository(): string
    {
        return BankMasterRepository::class;
    }

    /**
     * List bank.
     *
     * @return mixed
     */
    public function listBank()
    {
        return $this->bankMaster->listBank();
    }

    /**
     * Get data bank.
     *
     * @param $text
     * @return mixed
     */
    public function getDataBank($text)
    {
        $data = $this->bankMaster
            ->where('type', DBConstant::BANK_TYPE);

        if ($text) {
            $limelight = new Limelight();
            $results = $limelight->parse($text);
            $katakana = $results->toKatakana()->string('word');

            $data = $data->where(function ($query) use ($text, $katakana) {
                $query->whereRaw("LOWER(name) like BINARY LOWER('" . $text . "%')")
                    ->orWhereRaw("name_kana like BINARY '" . $katakana . "%'");
            });
        }

        return $data->get();
    }

    /**
     * Get data branch.
     *
     * @param $bank
     * @param $text
     * @return mixed
     */
    public function getDataBranch($bank, $text)
    {
        $limelight = new Limelight();
        $results = $limelight->parse($text);
        $katakana = $results->toKatakana()->string('word');

        $dataBank = $this->bankMaster->where('type', DBConstant::BANK_TYPE)->where('name', $bank)->first();
        if (isset($bank) && isset($text)) {
            return $this->bankMaster
                ->where('type', DBConstant::BRANCH_TYPE)
                ->where('parent_id', $dataBank->code)->where(function ($query) use ($text, $katakana) {
                    $query->whereRaw("LOWER(name) like BINARY LOWER('" . $text . "%')")
                          ->orWhereRaw("name_kana like BINARY '" . $katakana . "%'")
                          ->orWhere('code_number', $text);
                })->get();
        }
        if (isset($dataBank)) {
            return $this->bankMaster->where('type', DBConstant::BRANCH_TYPE)->where('parent_id', $dataBank->code)->get();
        }
        return [];
    }


}

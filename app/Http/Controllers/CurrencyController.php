<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Currency;
use App\Symbol;

class CurrencyController extends Controller
{
    public function index(){
        $first = $this->getFirst();
        $firstTime = ($first) ? floatval($first->time) : 3601;
        $time = time();
        $diff = $time - $firstTime;
        
        if($diff >= 3600){

            DB::beginTransaction();
            try {
                Currency::truncate();
                Symbol::truncate();

                $getCurrencies = $this->getCurrenciesSymbols('latest');
                $getSymbols = $this->getCurrenciesSymbols('symbols');
    
                $arrayCurrencies = [];
                $arraySymbols = [];
    
                foreach ($getCurrencies['rates'] as $key => $value) {
                    $arrayCurrencies [] = ['name' => $key, 'value' => $value];
                    Currency::create([
                        'name' => $key,
                        'value' => $value,
                        'time' => $time
                    ]);
                }

                foreach ($getSymbols['symbols'] as $key => $value) {
                    $arraySymbols [] = ['name' => $key, 'value' => '('.$key.') '.$value];
                    Symbol::create([
                        'name' => $key,
                        'value' => '('.$key.') '.$value
                    ]);
                }

                DB::commit();

                return [
                    "currencies" => $arrayCurrencies,
                    "symbols" => $arraySymbols
                ];
                
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        }else{
            $currencies = Currency::select('name', 'value')->get();
            $symbols = Symbol::select('name', 'value')->get();
            return [
                'currencies' => $currencies,
                'symbols' => $symbols
            ];
        }
    }

    public function getFirst(){
        $currency = Currency::select('id', 'name', 'time')->first();
        if($currency){
            return $currency;
        }else{
            return 0;
        }
    }

    public function getCurrenciesSymbols($endpoint){
        $access_key = ENV('FIXER_KEY');

        $ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        // Access the exchange rate values, e.g. GBP:
        return $exchangeRates;
    }
    
}

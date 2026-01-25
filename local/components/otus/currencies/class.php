<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CurrenciesComponent extends CBitrixComponent
{
    public function executeComponent() {

        \Bitrix\Main\Loader::includeModule('currency');

        $allCurrencies = \Bitrix\Currency\CurrencyManager::getCurrencyList();

        $currencies = \Bitrix\Currency\CurrencyTable::getList()->fetchCollection();

        //dump($currencies);

        $this->arResult['RATE'] = 1;
        $this->arResult['AMOUNT_CNT'] = 1;
        if($this->arParams['CURRENCY']) {
            $this->arResult['CURRENCY'] = $allCurrencies[$this->arParams['CURRENCY']];
            /** @var \Bitrix\Currency\EO_Currency $currency */
            foreach ($currencies as $currency) {
                //dump($currency);
                if($currency->getCurrency() == $this->arParams['CURRENCY']) {
                    $this->arResult['RATE'] = $currency->getAmount();
                    $this->arResult['AMOUNT_CNT'] = $currency->getAmountCnt();
                }
            }
        }

        $this->includeComponentTemplate();
    }
}

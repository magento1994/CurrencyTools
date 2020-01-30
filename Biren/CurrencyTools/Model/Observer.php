<?php

namespace Biren\CurrencyTools\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Locale\Currency;
use Magento\Framework\Locale\Resolver as LocaleResolver;

class Observer implements ObserverInterface
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var LocaleResolver
     */
    protected $localeResolver;

    /**
     * Observer constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param LocaleResolver       $localeResolver
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        LocaleResolver $localeResolver
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->localeResolver = $localeResolver;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $baseCode = strtolower($observer->getEvent()->getBaseCode());
        $currencyOptions = $observer->getEvent()->getCurrencyOptions();


        $symbol = $this->scopeConfig->getValue(
            "currency/symbols/" . $baseCode,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if (!$symbol) {
            return $this;
        }
        if ($symbol) {
            $currencyOptions->setData(
                Currency::CURRENCY_OPTION_SYMBOL, $symbol
            );
        }

        $postion = $this->scopeConfig->getValue(
            "currency/positions/" . $baseCode,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($postion == "left") {
            $currencyOptions->setData("position", \Zend_Currency::LEFT);
        } else {
            if ($postion == "right") {
                $currencyOptions->setData("position", \Zend_Currency::RIGHT);
            }
        }
        return $this;
    }
}

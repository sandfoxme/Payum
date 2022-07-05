<?php

namespace Payum\Core\Tests\Model;

use Payum\Core\Model\CreditCard;
use Payum\Core\Model\CreditCardInterface;
use Payum\Core\Security\SensitiveValue;
use Payum\Core\Tests\TestCase;

class CreditCardTest extends TestCase
{
    /**
     * @test
     */
    public function shouldExtendDetailsAwareInterface()
    {
        $rc = new \ReflectionClass(CreditCard::class);

        $this->assertTrue($rc->implementsInterface(CreditCardInterface::class));
    }

    /**
     * @test
     */
    public function shouldReturnNullOnNewCreditCard()
    {
        $card = new CreditCard();

        $this->assertNull($card->getToken());
        $this->assertNull($card->getBrand());
        $this->assertNull($card->getHolder());
        $this->assertNull($card->getMaskedHolder());
        $this->assertNull($card->getNumber());
        $this->assertNull($card->getMaskedNumber());
        $this->assertNull($card->getSecurityCode());
        $this->assertNull($card->getExpireAt());
    }

    /**
     * @test
     */
    public function shouldAllowGetPreviouslySetBrand()
    {
        $card = new CreditCard();

        $card->setBrand('theBrand');

        $this->assertSame('theBrand', $card->getBrand());
    }

    /**
     * @test
     */
    public function shouldAllowGetPreviouslySetToken()
    {
        $card = new CreditCard();

        $card->setToken('theToken');

        $this->assertSame('theToken', $card->getToken());
    }

    /**
     * @test
     */
    public function shouldAllowGetPreviouslySetHolder()
    {
        $card = new CreditCard();

        $card->setHolder('Mahatma Gandhi');

        $this->assertSame('Mahatma Gandhi', $card->getHolder());
    }

    /**
     * @test
     */
    public function shouldStoreHolderAsSensitiveValue()
    {
        $card = new CreditCard();

        $card->setHolder('Mahatma Gandhi');

        $value = $this->readAttribute($card, 'securedHolder');
        $this->assertInstanceOf(SensitiveValue::class, $value);
        $this->assertSame('Mahatma Gandhi', $value->peek());
    }

    /**
     * @test
     */
    public function shouldAllowGetMaskedHolderWhenSetHolder()
    {
        $card = new CreditCard();

        $card->setHolder('Mahatma Gandhi');

        $this->assertSame('MXXXXXX XXndhi', $card->getMaskedHolder());
    }

    /**
     * @test
     */
    public function shouldAllowChangeMaskedHolder()
    {
        $card = new CreditCard();

        $card->setHolder('Mahatma Gandhi');
        $card->setMaskedHolder('theMaskedHolder');

        $this->assertSame('Mahatma Gandhi', $card->getHolder());
        $this->assertSame('theMaskedHolder', $card->getMaskedHolder());
    }

    /**
     * @test
     */
    public function shouldAllowGetPreviouslySetNumber()
    {
        $card = new CreditCard();

        $card->setNumber('1234 5678 1234 5678');

        $this->assertSame('1234 5678 1234 5678', $card->getNumber());
    }

    /**
     * @test
     */
    public function shouldStoreNumberAsSensitiveValue()
    {
        $card = new CreditCard();

        $card->setNumber('1234 5678 1234 5678');

        $value = $this->readAttribute($card, 'securedNumber');
        $this->assertInstanceOf(SensitiveValue::class, $value);
        $this->assertSame('1234 5678 1234 5678', $value->peek());
    }

    /**
     * @test
     */
    public function shouldAllowGetMaskedNumberWhenSetNumber()
    {
        $card = new CreditCard();

        $card->setNumber('1234 5678 1234 5678');

        $this->assertSame('1XXX XXXX XXXX 5678', $card->getMaskedNumber());
    }

    /**
     * @test
     */
    public function shouldAllowChangeMaskedNumber()
    {
        $card = new CreditCard();

        $card->setNumber('1234 5678 1234 5678');
        $card->setMaskedNumber('theMaskedNumber');

        $this->assertSame('1234 5678 1234 5678', $card->getNumber());

        $this->assertSame('theMaskedNumber', $card->getMaskedNumber());
    }

    /**
     * @test
     */
    public function shouldAllowGetPreviouslySetSecurityCode()
    {
        $card = new CreditCard();

        $card->setSecurityCode('theCode');

        $this->assertSame('theCode', $card->getSecurityCode());
    }

    /**
     * @test
     */
    public function shouldStoreSecurityCodeAsSensitiveValue()
    {
        $card = new CreditCard();

        $card->setSecurityCode('123');

        $value = $this->readAttribute($card, 'securedSecurityCode');
        $this->assertInstanceOf(SensitiveValue::class, $value);
        $this->assertSame('123', $value->peek());
    }

    /**
     * @test
     */
    public function shouldAllowGetPreviouslySetExpireAt()
    {
        $card = new CreditCard();

        $expected = new \DateTime();

        $card->setExpireAt($expected);

        $this->assertSame($expected, $card->getExpireAt());
    }

    /**
     * @test
     */
    public function shouldStoreExpireAtAsSensitiveValue()
    {
        $card = new CreditCard();

        $expected = new \DateTime();

        $card->setExpireAt($expected);

        $value = $this->readAttribute($card, 'securedExpireAt');
        $this->assertInstanceOf(SensitiveValue::class, $value);
        $this->assertSame($expected, $value->peek());
    }
}

<?php

namespace Payum\Paypal\Rest\Tests\Action;

use ArrayObject;
use PayPal\Api\Payment as PaypalPayment;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\Capture;
use Payum\Paypal\Rest\Action\CaptureAction;
use Payum\Paypal\Rest\Model\PaymentDetails;
use PHPUnit\Framework\TestCase;
use stdClass;

class CaptureActionTest extends TestCase
{
    public function testShouldSupportCaptureWithPaymentSdkModel(): void
    {
        $action = new CaptureAction();

        $model = new PaymentDetails();

        $request = new Capture($model);

        $this->assertTrue($action->supports($request));
    }

    public function testShouldSupportCaptureWithArrayObjectModel(): void
    {
        $action = new CaptureAction();

        $model = new ArrayObject();

        $request = new Capture($model);

        $this->assertTrue($action->supports($request));
    }

    public function testShouldNotSupportCapturePaymentSdkModel(): void
    {
        $action = new CaptureAction();

        $request = new Capture(new stdClass());

        $this->assertFalse($action->supports($request));
    }

    public function testThrowIfNotSupportedRequestGivenAsArgumentForExecute(): void
    {
        $this->expectException(RequestNotSupportedException::class);
        $action = new CaptureAction();

        $action->execute(new stdClass());
    }

    public function testShouldNotSupportNotCapture(): void
    {
        $action = new CaptureAction();

        $this->assertFalse($action->supports(new stdClass()));
    }

    public function testShouldSupportCapture(): void
    {
        $action = new CaptureAction();

        $request = new Capture($this->createMock(PaypalPayment::class));

        $this->assertTrue($action->supports($request));
        $this->assertTrue($action->supports(new Capture(new ArrayObject())));
    }

    public function testThrowIfNotSupportedApiContext(): void
    {
        $this->expectException(UnsupportedApiException::class);
        $action = new CaptureAction();

        $action->setApi(new stdClass());
    }
}

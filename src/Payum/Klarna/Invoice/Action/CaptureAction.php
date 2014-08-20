<?php
namespace Payum\Klarna\Invoice\Action;

use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Capture;
use Payum\Core\Request\Sync;
use Payum\Klarna\Invoice\Request\Api\Activate;
use Payum\Klarna\Invoice\Request\Api\ReserveAmount;

class CaptureAction extends PaymentAwareAction
{
    /**
     * {@inheritDoc}
     *
     * @param Capture $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $details = ArrayObject::ensureArrayObject($request->getModel());

        if (false == $details['rno']) {
            $this->payment->execute(new ReserveAmount($details));
        }

        if ($details['rno'] && false == $details['invoice_number']) {
            $this->payment->execute(new Activate($details));
        }

        $this->payment->execute(new Sync($details));
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
<?php
namespace Devina\KerupukJulak\Service;

use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\Transactions;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Transactions\TransactionsSaveRequest;
use Devina\KerupukJulak\Model\Transactions\TransactionsSaveResponse;
use Devina\KerupukJulak\Model\Transactions\TransactionsUpdateRequest;
use Devina\KerupukJulak\Model\Transactions\TransactionsUpdateResponse;
use Devina\KerupukJulak\Repository\TransactionsRepository;

class TransactionsService
{
    private TransactionsRepository $transactionsRepository;

    public function __construct(TransactionsRepository $transactionsRepository)
    {
        $this->transactionsRepository = $transactionsRepository;
    }

    public function addTransactions(TransactionsSaveRequest $request) : TransactionsSaveResponse
    {
        $this->validateAddTransactions($request);
        try {
            Database::beginTransaction();
            $transaction = new Transactions();
            $transaction->id = "ORD" . uniqid();
            $transaction->account_id = $request->account_id;
            $transaction->total_price = $request->total_price;
            $transaction->payment_confirm = $request->payment_confirm;
            $transaction->status = "Menunggu";

            $this->transactionsRepository->save($transaction);
            Database::commitTransaction();
            $response = new TransactionsSaveResponse();
            $response->transactions = $transaction;
            return $response;
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function validateAddTransactions(TransactionsSaveRequest $request)
    {
        if($request->account_id == null || $request->total_price == null || trim($request->account_id) == ""){
            throw new ValidationException("Gagal melakukan checkout barang ada");
        }
    }

    public function updateStatus(TransactionsUpdateRequest $request) : TransactionsUpdateResponse
    {
        try {
            Database::beginTransaction();
            $transaction = $this->transactionsRepository->findById($request->id);
            if($transaction == null){
                throw new ValidationException("Gagal mengupdate status");
            }

            $transaction->status = $request->status;
            $this->transactionsRepository->update($transaction);
            Database::commitTransaction();
            $response = new TransactionsUpdateResponse();
            $response->transactions = $transaction;

            return $response;
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
}
<?php

namespace Devina\KerupukJulak\Service;

use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\DetailTransactions;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByDateRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByDateResponse;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByIdRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByIdResponse;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByUserRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayByUserResponse;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsDisplayResponse;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsSaveRequest;
use Devina\KerupukJulak\Model\DetailTransactions\DetailTransactionsSaveResponse;
use Devina\KerupukJulak\Repository\DetailTransactionsRepository;

class DetailTransactionsService
{
    private DetailTransactionsRepository $detailTransactionsRepository;

    public function __construct(DetailTransactionsRepository $detailTransactionsRepository)
    {
        $this->detailTransactionsRepository = $detailTransactionsRepository;
    }

    public function addDetailTransaction(DetailTransactionsSaveRequest $request): DetailTransactionsSaveResponse
    {
        $this->validateAddDetailTransactions($request);
        try {
            Database::beginTransaction();
            $detailTransaction = new DetailTransactions();
            $detailTransaction->id = "DORD" . uniqid();
            $detailTransaction->transaction_id = $request->transaction_id;
            $detailTransaction->products_id = $request->products_id;
            $detailTransaction->quantity = $request->quantity;

            $this->detailTransactionsRepository->save($detailTransaction);
            Database::commitTransaction();

            $response = new DetailTransactionsSaveResponse();
            $response->detailTransactions = $detailTransaction;

            return $response;
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function validateAddDetailTransactions(DetailTransactionsSaveRequest $request)
    {
        if (
            $request->transaction_id == null || $request->products_id == null || $request->quantity == null ||
            trim($request->transaction_id) == "" || trim($request->products_id) == ""
        ) {
            throw new ValidationException("Gagal melakukan checkout barang");
        }
    }

    public function displayAllTransactions(string $tipe): DetailTransactionsDisplayResponse
    {
        try {
            if ($tipe == "Transactions") {
                $detailTransactions = $this->detailTransactionsRepository->findAll();
            } else if ($tipe == "Report") {
                $detailTransactions = $this->detailTransactionsRepository->findAllHistory();
            }
            if ($detailTransactions == null) {
                throw new ValidationException("Belum ada pesanan apapun");
            }

            $response = new DetailTransactionsDisplayResponse();
            $response->detailTransactions = $detailTransactions;
            return $response;
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    public function displayByDate(DetailTransactionsDisplayByDateRequest $request): DetailTransactionsDisplayByDateResponse
    {
        try {
            $detailTransactions = $this->detailTransactionsRepository->findAllByDate($request->start_date, $request->end_date);
            if ($detailTransactions == null) {
                throw new ValidationException("Belum ada pesanan apapun");
            }

            $response = new DetailTransactionsDisplayByDateResponse();
            $response->detailTransactions = $detailTransactions;
            return $response;
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    public function displayAllByDate(DetailTransactionsDisplayByDateRequest $request): DetailTransactionsDisplayByDateResponse
    {
        try {
            $detailTransactions = $this->detailTransactionsRepository->findAllHistoryByDate($request->start_date, $request->end_date);
            if ($detailTransactions == null) {
                throw new ValidationException("Belum ada pesanan apapun");
            }

            $response = new DetailTransactionsDisplayByDateResponse();
            $response->detailTransactions = $detailTransactions;
            return $response;
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    public function displayAllByUserTransactions(DetailTransactionsDisplayByUserRequest $request,string $status): DetailTransactionsDisplayByUserResponse
    {
        try {
            $detailTransactions = $this->detailTransactionsRepository->findAllByAccountId($request->account_id, $status);
            if ($detailTransactions == null) {
                throw new ValidationException("Belum ada pesanan apapun");
            }

            $response = new DetailTransactionsDisplayByUserResponse();
            $response->detailTransactions = $detailTransactions;

            return $response;
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    public function displayDetail(DetailTransactionsDisplayByIdRequest $request): DetailTransactionsDisplayByIdResponse
    {
        try {
            $detailTransaction = $this->detailTransactionsRepository->findAllDetail($request->id);
            if ($detailTransaction == null) {
                throw new ValidationException("Telah terjadi error");
            }
            $response = new DetailTransactionsDisplayByIdResponse();
            $response->detailTransactions = $detailTransaction;

            return $response;
        } catch (ValidationException $e) {
            throw $e;
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\StoreCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    /**
     * Отображает список ресурсов.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $currencies = Currency::all();
        return CurrencyResource::collection($currencies);
    }

    /**
     * Сохраняет вновь созданный ресурс в хранилище.
     *
     * @param  \App\Http\Requests\Currency\StoreCurrencyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCurrencyRequest $request)
    {
        $currency = Currency::create($request->validated());
        return (new CurrencyResource($currency))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Отображает указанный ресурс.
     *
     * @param  \App\Models\Currency  $currency
     * @return CurrencyResource
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    /**
     * Обновляет указанный ресурс в хранилище.
     *
     * @param  \App\Http\Requests\Currency\UpdateCurrencyRequest  $request
     * @param  \App\Models\Currency  $currency
     * @return CurrencyResource
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->validated());
        return new CurrencyResource($currency->fresh());
    }

    /**
     * Удаляет указанный ресурс из хранилища.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace Bm\Store\Controller;

use Bm\Store\Entity\Taxe;
use Bm\Store\Repository\TaxeRepository;
use Bm\Store\Util\JsonResponse;

class TaxeController
{
    protected $taxeRepository;

    public function __construct()
    {
        $this->taxeRepository = new TaxeRepository;
    }

    public function getAll()
    {
        $data = $this->taxeRepository->getAll();
        $taxes = [];
        foreach ($data as $taxe) {
            $taxes[] = $taxe->toJsonArray();
        }
        return JsonResponse::send($taxes);
    }

    public function getById($args)
    {
        $taxe = $this->taxeRepository->getById($args['taxes']);
        if (!$taxe) {
            return JsonResponse::send('Taxe not found', 404);
        }
        return JsonResponse::send($taxe->toJsonArray());
    }

    public function store($request)
    {
        $taxe = new Taxe;
        $taxe->category_id = $request->category_id;
        $taxe->percentage = $request->percentage;

        $this->taxeRepository->create($taxe);

        return JsonResponse::send('Taxe saved successfully', 201);
    }

    public function update($request, $args)
    {
        $taxe = $this->taxeRepository->getById($args['taxes']);

        if (!$taxe) {
            return JsonResponse::send('Taxe not found', 404);
        }

        $taxe->category_id = $request->category_id;
        $taxe->percentage = $request->percentage;

        $this->taxeRepository->update($args['taxes'], $taxe);

        return JsonResponse::send('Taxe updated successfully');
    }

    public function delete($args)
    {
        $taxe = $this->taxeRepository->getById($args['taxes']);

        if (!$taxe) {
            return JsonResponse::send('Taxe not found', 404);
        }

        $this->taxeRepository->delete($args['taxes']);

        return JsonResponse::send('Taxe deleted successfully');
    }
}

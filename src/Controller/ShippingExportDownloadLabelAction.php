<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Controller;

use BitBag\SyliusShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webmozart\Assert\Assert;

final class ShippingExportDownloadLabelAction
{
    /** @var Filesystem */
    private $filesystem;

    /** @var ShippingExportRepositoryInterface */
    private $repository;

    /** @var string */
    private $shippingLabelsPath;

    public function __construct(
        Filesystem $filesystem,
        ShippingExportRepositoryInterface $repository,
        string $shippingLabelsPath
    ) {
        $this->filesystem = $filesystem;
        $this->repository = $repository;
        $this->shippingLabelsPath = $shippingLabelsPath;
    }

    public function __invoke(Request $request): Response
    {
        $shippingExport = $this->repository->find($request->get('id'));
        Assert::notNull($shippingExport);
        $labelPath = $shippingExport->getLabelPath();
        Assert::notNull($labelPath);

        if (dirname($labelPath) !== $this->shippingLabelsPath) {
            throw new NotFoundHttpException(sprintf('Directory traversal is not allowed for label "%s"', $labelPath));
        }

        if (false === $this->filesystem->exists($labelPath)) {
            throw new NotFoundHttpException();
        }

        $filePathParts = explode(\DIRECTORY_SEPARATOR, $labelPath);
        $labelName = end($filePathParts);

        return $this->createStreamedResponse($labelPath, $labelName);
    }

    private function createStreamedResponse(string $filePath, string $fileName): StreamedResponse
    {
        $response = new StreamedResponse(
            function () use ($filePath): void {
                $outputStream = fopen('php://output', 'wb');
                Assert::resource($outputStream);
                $fileStream = fopen($filePath, 'rb');
                Assert::resource($fileStream);
                stream_copy_to_stream($fileStream, $outputStream);
            }
        );

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}

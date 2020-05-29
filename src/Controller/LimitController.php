<?php
declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Controller;

use Twig\Environment;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Artesanik\SyliusEmployeePlugin\Repository\CustomerRepository;
use Artesanik\SyliusEmployeePlugin\Repository\Employee\LimitRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class LimitController extends ResourceController
{
    /** @var Enviroment */
    private $twig;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var LimitRepositoryInterface */
    private $limitRepository;

    /** @var TranslatorInterface */
    private $translator;

    /** @var SessionInterface */
    private $session;

    public function __construct(
        Environment $twig,
        CustomerRepository $customerRepository,
        LimitRepository $limitRepository,
        TranslatorInterface $translator,
        SessionInterface $session
    ) {
        $this->twig = $twig;
        $this->customerRepository = $customerRepository;
        $this->limitRepository = $limitRepository;
        $this->translator = $translator;
        $this->session = $session;
    }

    public function indexAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->isGrantedOr403($configuration, ResourceActions::SHOW);
        $limit = $this->findOr404($configuration);

        $recommendationService = $this->get('artesanik_sylius_employee.factory.limit');

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $limit);

        $view = View::create($limit);

        if ($configuration->isHtmlRequest()) {
            $view
                ->setTemplate('@ArtesanikSyliusEmployeePlugin/Admin'.(ResourceActions::SHOW . '.html'))
                ->setTemplateVar($this->metadata->getName())
                ->setData([
                    'configuration' => $configuration,
                    'metadata' => $this->metadata,
                    'resource' => $limit,
                    $this->metadata->getName() => $limit,
                ])
            ;
        }

        return $this->viewHandler->handle($configuration, $view);
    }

    public function limitBalanceAction(Request $request): Response
    {
        $customer = $request->get('customer');
        $channel = $this->get('sylius.context.channel')->getChannel();
        $expenses = $this->customerRepository->countOrderItemsByLimit($channel, $customer);
        return $this->render(
            '@ArtesanikSyliusEmployeePlugin/Customer/Show/Employee/Summary/_limitBalance.html.twig',
            [
                'expenses' => $expenses
            ]
        );
    }
}

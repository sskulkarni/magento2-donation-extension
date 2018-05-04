<?php
namespace Krishaweb\Donation\Controller\Index;

use \Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class Setdonation extends Action
{
    /**
     * @var  \Magento\Framework\View\Result\Page
     */

    protected $quoteRepository;

    protected $resultPageFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Customer\Model\Session $customerSession,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
                                \Magento\Framework\UrlInterface $urlInterface,
                                \Magento\Quote\Model\QuoteRepository $quoteRepository)
    {
        $this->session = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->_jsonResultFactory = $jsonResultFactory;
        $this->_urlInterface = $urlInterface;
        $this->quoteRepository = $quoteRepository;
        parent::__construct($context);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        try{
                
                $result['status'] = 'fail';
                $resultF = $this->_jsonResultFactory->create();
                $resultPage = $this->resultPageFactory->create();
                $data = $this->getRequest()->getPost();
                

                $donation = (int)$data->donate_amount;

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $quoteId = $objectManager->create('Magento\Checkout\Model\Session')->getQuote()->getId();
                
                $quote = $this->quoteRepository->get($quoteId); 
                $quote->setData('donation_amount', $donation); 
                $this->quoteRepository->save($quote); 


                 $grand_total = $quote->getGrandTotal();
                 $new_grand_total = $grand_total + $donation;
                 $quote->setGrandTotal($new_grand_total);
                 $quote->setBaseGrandTotal($new_grand_total);
                 $quote->save();


                $quote->collectTotals()->save();

                
                $result['status'] = 'success';
                
                $o = json_encode($result);
                $resultF->setData($o);
                return $resultF; 

        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $error = true;
            $this->messageManager->addError($e->getMessage());
            $result['message'] = $e->getMessage();
            $result['status'] = 'fail';
        } catch (\Exception $e) {
            $error = true;
            $this->messageManager->addException($e, __('We can\'t delete right now. '.$e->getMessage()));
            $result['message'] = $e->getMessage();
            $result['status'] = 'fail';
        }
        
    }
}
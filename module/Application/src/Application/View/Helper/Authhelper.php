<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Application\Model\CountryTable;
 use Application\Controller\AppController;
//  use Zend\ServiceManager\ServiceLocatorAwareInterface;
// use Zend\ServiceManager\ServiceLocatorInterface;
class Authhelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
     // protected $serviceLocator;

  protected $liveStreamingTable;

  public function __construct(LiveStreamingTable $liveStreamingTable)
  {
    $this->liveStreamingTable = $liveStreamingTable;
  }

  public function getLiveStreamingTable()
  {
    return $this->liveStreamingTable;
  } 

  //     public function __construct(ServiceLocatorInterface $serviceLocator)
  // {
  //   $this->serviceLocator = $serviceLocator;
  // }

  // public function setServiceLocator(ServiceLocatorInterface $serviceLocator);

  // public function getServiceLocator();

  //  public function getLiveStreamingTable()
  // {
  //   if (null == $this->liveStreamingTable) {
  //     $this->liveStreamingTable = $this->getServiceLocator()->get('Application\Model\CountryTable');
  //   }
  //   return $this->liveStreamingTable;
  // } 

  //   public function __invoke($str, $find)
  //   {
  //   //     $state = new Model_DbTable_States();
  //   // return $this->_list->getStates();
        
  //       $app = new AppController();

  //       // $country = $app->getCountryTable();

  //       // $adapter=$this->getServiceLocator()->get('CountryTable');

  //       if (! is_string($str)){
  //           return 'must be string';
  //       }
 
  //       if (strpos($str, $find) === false){
  //           return 'not found';
  //       }
 
  //       return 'found';
  //   }

  //   public function hello()
  //   {
  //       return "xcvhkvhxkjcvhxkjchvjkx";
  //   }
}
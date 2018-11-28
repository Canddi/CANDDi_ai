<?php
/**
 * @category
 * @package
 * @copyright  2011-06-05 (c) 2011 Campaign and Digital Intelligence (http://canddi.com)
 * @license
 * @author     Oli Wood
 **/


use Canddi\Account\Widget\WidgetAbstract as NS_Widget_Abstract;
use Canddi\Message\TriggerAction as NS_MessageTriggerAction;
use Canddi\TriggerActionModel\Notify AS NS_TriggerActionModel_Notify;
use Canddi\TriggerActionModel\NotifyHipchat AS NS_TriggerActionModel_NotifyHipchat;

class Canddi_MessageTest extends Canddi_TestCase
{
    public function setUp()
    {
        parent::setUp();
        //This is required - otherwise this fails
        // because of the checks on
        // $mockMessage        = Mockery::mock("Canddi_Message");
        // Canddi_Message::inject($mockMessage);
        Canddi_Message::inject(null);
    }
    public function testCheckStream()
    {
        $strAccountURL  = 'canddi';
        $guidContact    = '123';

        $return = Canddi_Message::getInstance()->CheckStream(
            $strAccountURL,
            $guidContact,
            false
        );
        $this->assertTrue($return instanceof Canddi_Message_CheckStream);
    }
    public function testContacts_Company()
    {
        $strAccountURL  = 'canddi';
        $guidContact    = '123';
        $guidCompany        = "df46ff5b2abeab8c7e9e4752b0d912e2";
        $arrInStreams       = ["bcdfe244792b31726c2877ec78bb5432", "cfd419dd3bc925dd1ff5425afa4bd918"];
        $intTimeCreated     = 1539679096;
        $intTimeLastSession = 1484926199;
        $intTotalActivities = 88;
        $intTotalContacts   = 2;
        $intTotalDuration   = 1969;
        $intTotalSessions   = 20;

        $mockCompany    = Mockery::mock("Canddi_Model_SecondOrder_Company_Model")
            ->shouldReceive('getId')
            ->once()
            ->andReturn($guidCompany)
            ->shouldReceive('getTotalSessions')
            ->once()
            ->andReturn($intTotalSessions)
            ->shouldReceive('getTotalActivities')
            ->once()
            ->andReturn($intTotalActivities)
            ->shouldReceive('getTotalDuration')
            ->once()
            ->andReturn($intTotalDuration)
            ->shouldReceive('getTotalContacts')
            ->once()
            ->andReturn($intTotalContacts)
            ->shouldReceive('getTimeLastSession')
            ->once()
            ->andReturn($intTimeLastSession)
            ->shouldReceive('getInStreams')
            ->once()
            ->andReturn($arrInStreams)
            ->mock();

        $return = Canddi_Message::getInstance()->Contacts_Company(
            $strAccountURL,
            $guidContact,
            $mockCompany
        );
        $this->assertTrue($return instanceof Canddi_Message_Contacts_Company);
    }
    public function testContacts_Merge()
    {
        $strAccountURL          = "anAccount";
        $strContactIdToKeep     = md5(1);
        $arrContactIdsToMerge   = [md5(2)];
        $arrIdentifiedIds       = ["FCId_123"];
        $strReason              = "a reason";

        $return     = Canddi_Message::getInstance()->Contacts_Merge(
            $strAccountURL,
            $strContactIdToKeep,
            $arrContactIdsToMerge,
            $arrIdentifiedIds,
            $strReason
        );
        $this->assertTrue($return instanceof Canddi_Message_Contacts_Merge);
    }
    public function testContacts_SessionGoal()
    {
        $arrSessionGoals        = [
            '_id' => 1,
            'SessionGUID' => 'id',
            'Actions' => [],
            'Duration' => 1,
            'TimeCreated' => 1,
            'GoalTitle' => 'title',
            'GoalType' => 'type',
            'SessionGoalTypeId' => 2
        ];

        $mockSessionGoal    = Mockery::mock("Canddi_Model_FirstOrder_SessionGoal_Abstract")
            ->shouldReceive('getContactId')
            ->once()
            ->andReturn(md5(1))
            ->shouldReceive('getAccountURL')
            ->once()
            ->shouldReceive('bDontDisplayMe')
            ->once()
            ->andReturn(false)
            ->shouldReceive('getSessionGUID')
            ->once()
            ->andReturn($arrSessionGoals['SessionGUID'])
            ->shouldReceive('getSessionGoalId')
            ->once()
            ->andReturn($arrSessionGoals['_id'])
            ->shouldReceive('getDuration')
            ->once()
            ->andReturn($arrSessionGoals['Duration'])
            ->shouldReceive('getCleanProcessActions')
            ->once()
            ->andReturn($arrSessionGoals['Actions'])
            ->shouldReceive('getGoalTitle')
            ->once()
            ->andReturn($arrSessionGoals['GoalTitle'])
            ->shouldReceive('getGoalType')
            ->once()
            ->andReturn($arrSessionGoals['GoalType'])
            ->shouldReceive('getSessionGoalTypeId')
            ->once()
            ->andReturn($arrSessionGoals['SessionGoalTypeId'])
            ->shouldReceive('getTimeCreated')
            ->once()
            ->andReturn($arrSessionGoals['TimeCreated'])
            ->mock();
        $intTotalDuration   = 1000;

        $return     = Canddi_Message::getInstance()->Contacts_SessionGoal(
            $mockSessionGoal,
            $intTotalDuration
        );
        $this->assertTrue($return instanceof Canddi_Message_Contacts_SessionGoal);
    }
    public function testDevShare()
    {
        $strSenderName     = "Anosh";
        $strRecipientName  = "Tim";
        $strRecipientEmail = "tim@canddi.com";
        $strComment        = "I require assistance!";
        $strAccountName    = "Canddi Motors";
        $guidTracker       = "7fd4d2d2d6052c76a5c43eb6a6523533";
        $strClientType     = 'canddi';

        $return = Canddi_Message::getInstance()->DevShare(
            $strSenderName,
            $strRecipientName,
            $strComment,
            $strAccountName,
            $strRecipientEmail,
            $guidTracker,
            $strClientType
        );
        $this->assertTrue($return instanceof Canddi_Message_DevShare);
    }
    public function testEmailPlugin_RealTime()
    {
        $strEmailAddress    = "tim@canddi.com";
        $arrActivity        = [];
        $intSend            = 1;
        $intTracked         = 2;
        $intOpened          = 3;
        $intIdentified      = 4;

        $message        = Canddi_Message::getInstance()->EmailPlugin_RealTime(
            $strEmailAddress,
            $arrActivity,
            $intSend,
            $intTracked,
            $intOpened,
            $intIdentified
        );
        $this->assertTrue($message instanceof Canddi_Message_EmailPlugin_Realtime);
    }
    public function testExpire()
    {
        $strAccountURL  = "canddi";
        $strType        = "Tag";
        $intTime        = time();
        $strKey         = "zSet_tim";

        $message        = Canddi_Message::getInstance()->Expire(
            $strAccountURL,
            $strType,
            $intTime,
            $strKey
        );
        $this->assertTrue($message instanceof Canddi_Message_Expire);
    }
    public function testExport_Stream()
    {
        $strAccountURL		= "anAccount";
        $strStreamId		= md5(1);
        $arrIncludeFields	= [];
        $strEmailAddress    = "tim@tim";
        $mockHelperFields 	= Mockery::mock("Canddi_Model_Helper_Fields")
            ->shouldReceive('getRawArray')
            ->once()
            ->andReturn($arrIncludeFields)
            ->mock();
        $guidDownloadId		= md5(2);
        $intTimeFrom		= time();
        $intTimeTo			= time();

        $message 		= Canddi_Message::getInstance()->Export_Stream(
            $strAccountURL,
            $strEmailAddress,
            $strStreamId,
            $mockHelperFields,
            $guidDownloadId,
            $intTimeFrom,
            $intTimeTo
        );
        $this->assertTrue($message instanceof Canddi_Message_Export_Stream);
    }
    public function testNotification_Account_Field()
    {
        $mockAccountWidget  = Mockery::mock(NS_Widget_Abstract::CLASS)
            ->shouldReceive('getAccountURL')
            ->once()
            ->shouldReceive('getId')
            ->once()
            ->mock();
        $mockField          = Mockery::mock("Canddi_Model_Canddi_Account_WidgetFields_Default")
            ->shouldReceive('getModelAccountWidget')
            ->once()
            ->andReturn($mockAccountWidget)
            ->mock();

        $message            = Canddi_Message::getInstance()->Notification_AccountWidgetField_Field(
            $mockField
        );
        $this->assertTrue($message instanceof Canddi_Notification_Message_AccountWidgetField_Field);
    }
    public function testNotification_Download_Success()
    {
        $strAccountName = "skysteve";
        $strAccountUrl = "sky";
        $strEmailAddress = "steve@canddi.com";
        $strName = "Steve";
        $strTitle = "Hello world";
        $arrDownloads = [];
        $strClientType = 'canddi';

        $mockAccount = Mockery::mock("Canddi_Model_Canddi_Account")
            ->shouldReceive('getClientType')
            ->once()
            ->withNoArgs()
            ->andReturn($strClientType)
            ->mock();

        $mockGwAccount = Mockery::mock("Canddi_Gateway_Account")
            ->shouldReceive('getById')
            ->once()
            ->with($strAccountUrl)
            ->andReturn($mockAccount)
            ->mock();

        $mockGw = Mockery::mock("Canddi_Gateway")
            ->shouldReceive('getAccount')
            ->once()
            ->withNoArgs()
            ->andReturn($mockGwAccount)
            ->mock();

        Canddi_Gateway::inject($mockGw);

        $message = Canddi_Message::getInstance()->Notification_Download_Success(
            $strAccountUrl,
            $strEmailAddress,
            $strName,
            $strTitle,
            $arrDownloads
        );

        $this->assertTrue($message instanceof Canddi_Notification_Message_Download_Success);
    }

    public function testNotification_Download_Error()
    {
        $strAccountName = "skysteve";
        $strAccountUrl = "sky";
        $strEmailAddress = "steve@canddi.com";
        $strName = "Steve";
        $strTitle = "Hello world";
        $strDownload = '';
        $strClientType = 'canddi';

        $mockAccount = Mockery::mock("Canddi_Model_Canddi_Account")
            ->shouldReceive('getClientType')
            ->once()
            ->withNoArgs()
            ->andReturn($strClientType)
            ->mock();

        $mockGwAccount = Mockery::mock("Canddi_Gateway_Account")
            ->shouldReceive('getById')
            ->once()
            ->with($strAccountUrl)
            ->andReturn($mockAccount)
            ->mock();

        $mockGw = Mockery::mock("Canddi_Gateway")
            ->shouldReceive('getAccount')
            ->once()
            ->withNoArgs()
            ->andReturn($mockGwAccount)
            ->mock();

        Canddi_Gateway::inject($mockGw);

        $message = Canddi_Message::getInstance()->Notification_Download_Error(
            $strAccountUrl,
            $strEmailAddress,
            $strName,
            $strTitle,
            $strDownload
        );

        $this->assertTrue($message instanceof Canddi_Notification_Message_Download_Error);
    }
    public function testNotification_Alert()
    {
        $strAccountURL  = 'test';
        $strEmailAddress= 'tim@canddi.com';
        $strDescription = 'test';
        $intType        = 1;

        $message        = Canddi_Message::getInstance()->Notification_Alert(
            $strAccountURL,
            $strEmailAddress,
            $strDescription,
            $intType
        );
        $this->assertTrue($message instanceof Canddi_Notification_Message_Alert);
    }
    public function testReprocess_AllTrackerGoals()
    {
        $strAccount         = 'canddi-motors';
        $strMatchValue      = "";

        $msg = Canddi_Message::getInstance()->Reprocess_AllTrackerGoals(
            $strAccount,
            $strMatchValue
        );

        $this->assertEquals(
            Canddi_Helper_Exchanges::EXCHANGE_REPROCESS,
            $msg->getTargetExchange()
        );

        $this->assertEquals($strAccount,        $msg->getAccountURL());
        $this->assertInstanceOf('Canddi_Message_Reprocess_AllTrackerGoals', $msg);
    }
    public function testReprocess_Contact()
    {
        $strAccount         = 'canddi-motors';
        $guidContact        = md5(1);

        $msg = Canddi_Message::getInstance()->Reprocess_Contact(
            $strAccount,
            $guidContact
        );

        $this->assertEquals(
            Canddi_Helper_Exchanges::EXCHANGE_REPROCESS,
            $msg->getTargetExchange()
        );

        $this->assertEquals($strAccount,        $msg->getAccountURL());
        $this->assertEquals($guidContact,       $msg->getContactId());
        $this->assertEquals(false,              $msg->getSendTriggers());
        $this->assertInstanceOf('Canddi_Message_Reprocess_Contact', $msg);
    }
    public function testReprocess_Identifier()
    {
        $strAccount         = 'canddi-motors';
        $strType            = "Email";
        $strValue           = "tim@canddi.com";

        $msg = Canddi_Message::getInstance()->Reprocess_Identifier(
            $strAccount,
            $strType,
            $strValue
        );

        $this->assertEquals(
            Canddi_Helper_Exchanges::EXCHANGE_REPROCESS,
            $msg->getTargetExchange()
        );

        $this->assertEquals($strAccount,        $msg->getAccountURL());
        $this->assertEquals($strType,        $msg->getType());
        $this->assertEquals($strValue,        $msg->getValue());
        $this->assertInstanceOf('Canddi_Message_Reprocess_Identifier', $msg);
    }
    public function testReprocess_Stream()
    {
        $strAccount         = 'canddi-motors';
        $guidStream         = md5(1);

        $msg = Canddi_Message::getInstance()->Reprocess_Stream(
            $strAccount,
            $guidStream
        );

        $this->assertEquals(
            Canddi_Helper_Exchanges::EXCHANGE_REPROCESS,
            $msg->getTargetExchange()
        );

        $this->assertEquals($strAccount,        $msg->getAccountURL());
        $this->assertEquals($guidStream,        $msg->getStreamId());
        $this->assertInstanceOf('Canddi_Message_Reprocess_Stream', $msg);
    }
    public function testReprocess_TrackerGoal()
    {
        $strAccount         = 'canddi-motors';
        $strTrackerGoalId   = md5(1);
        $strSessionGoalId   = md5(2);

        $msg = Canddi_Message::getInstance()->Reprocess_TrackerGoal(
            $strAccount,
            Canddi_Helper_TrackerType::ID_MANUAL,
            false,
            $strTrackerGoalId,
            $strSessionGoalId
        );

        $this->assertEquals(
            Canddi_Helper_Exchanges::EXCHANGE_REPROCESS,
            $msg->getTargetExchange()
        );

        $this->assertEquals($strTrackerGoalId,  $msg->getTrackerGoalId());
        $this->assertEquals($strSessionGoalId,  $msg->getSessionGoalId());
        $this->assertEquals($strAccount,        $msg->getAccountURL());
        $this->assertInstanceOf('Canddi_Message_Reprocess_TrackerGoal', $msg);
    }
    public function testSessionManual_CRM() {
        $strAccountURL = "account";
        $guidSession = md5(1);
        $guidContact = md5(2);
        $guidTracker = md5(3);
        $strGoalURL = "url";
        $arrRawPost = array(1, 2, 3);
        $strGoalTitle = "Goal title";

        $mockTracker        = Mockery::mock("Canddi_Model_Local_Tracker_Abstract")
            ->shouldReceive('getId')
            ->once()
            ->andReturn($guidTracker)
            ->mock();
        $ittTracker         = Mockery::mock("Canddi_Iterator_Interface")
            ->shouldReceive('count')
            ->once()
            ->andReturn(1)
            ->shouldReceive('current')
            ->once()
            ->andReturn($mockTracker)
            ->mock();
        $mockGwTracker      = Mockery::mock('Canddi_Gateway_Tracker')
            ->shouldReceive('getAll')
            ->once()
            ->with([
                Canddi_Model_Local_Tracker_Abstract::FIELD_TrackerTypeId => Canddi_Helper_TrackerType::ID_MANUAL
            ])
            ->andReturn($ittTracker)
            ->mock();
        $mockGw = Mockery::mock('Canddi_Gateway')
            ->shouldReceive('getTracker')
            ->once()
            ->with($strAccountURL)
            ->andReturn($mockGwTracker)
            ->mock();
        Canddi_Gateway::inject($mockGw);

        $strValue   = "tim@canddi.com";
        $msg = Canddi_Message::getInstance()->Session_Manual_CRM(
            $strAccountURL,
            $guidSession,
            $guidContact,
            $strGoalURL,
            $arrRawPost,
            $strGoalTitle,
            $strValue
        );

        $this->assertEquals(
            Canddi_Helper_Exchanges::EXCHANGE_WEBSITE,
            $msg->getTargetExchange()
        );

        $this->assertEquals($guidSession, $msg->getSessionGUID());
        $this->assertEquals($strGoalURL, $msg->getGoalURL());
        $this->assertEquals(json_encode($arrRawPost), $msg->getRawGoalPost());
        $this->assertEquals($strGoalTitle, $msg->getGoalTitle());
        $this->assertInstanceOf('Canddi_Message_Session_Manual_CRM', $msg);
    }
    public function testSessionManual_Normal() {
        $strAccountURL = "account";
        $guidSession = md5(1);
        $guidContact = md5(2);
        $guidTracker = md5(3);
        $strGoalURL = "url";
        $arrRawPost = array(1, 2, 3);
        $strGoalTitle = "Goal title";

        $mockTracker        = Mockery::mock("Canddi_Model_Local_Tracker_Abstract")
            ->shouldReceive('getId')
            ->once()
            ->andReturn($guidTracker)
            ->mock();
        $ittTracker         = Mockery::mock("Canddi_Iterator_Interface")
            ->shouldReceive('count')
            ->once()
            ->andReturn(1)
            ->shouldReceive('current')
            ->once()
            ->andReturn($mockTracker)
            ->mock();
        $mockGwTracker      = Mockery::mock('Canddi_Gateway_Tracker')
            ->shouldReceive('getAll')
            ->once()
            ->with([
                Canddi_Model_Local_Tracker_Abstract::FIELD_TrackerTypeId => Canddi_Helper_TrackerType::ID_MANUAL
            ])
            ->andReturn($ittTracker)
            ->mock();
        $mockGw = Mockery::mock('Canddi_Gateway')
            ->shouldReceive('getTracker')
            ->once()
            ->with($strAccountURL)
            ->andReturn($mockGwTracker)
            ->mock();
        Canddi_Gateway::inject($mockGw);

        $msg = Canddi_Message::getInstance()->Session_Manual_Normal(
            $strAccountURL,
            $guidSession,
            $guidContact,
            $strGoalURL,
            $arrRawPost,
            $strGoalTitle
        );

        $this->assertEquals(
            Canddi_Helper_Exchanges::EXCHANGE_WEBSITE,
            $msg->getTargetExchange()
        );

        $this->assertEquals($guidSession, $msg->getSessionGUID());
        $this->assertEquals($strGoalURL, $msg->getGoalURL());
        $this->assertEquals(json_encode($arrRawPost), $msg->getRawGoalPost());
        $this->assertEquals($strGoalTitle, $msg->getGoalTitle());
        $this->assertInstanceOf('Canddi_Message_Session_Manual_Normal', $msg);
    }
    public function testTriggerAction_BrowserPushDisabled()
    {
        $strClient       = 'canddi';
        $strEmailAddress = 'test@canddi.com';

        $message        = Canddi_Message::getInstance()->TriggerAction_BrowserPushDisabled(
            $strClient,
            $strEmailAddress
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\BrowserPushDisabled);
    }
    public function testTriggerAction_Callback()
    {
        $strAccountURL      = "anAccount";
        $guidContact        = md5(1);
        $guidStreamId       = md5(2);
        $strTriggerType     = "New";
        $strCallbackURL     = "http://callback.com";

        $message        = Canddi_Message::getInstance()->TriggerAction_Callback(
            $strAccountURL,
            $strTriggerType,
            $guidContact,
            $guidStreamId,
            $strCallbackURL
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\Callback);
    }
    public function testTracker()
    {
        $guidTracker    = md5(2);

        $return         = Canddi_Message::getInstance()->Tracker(
            $guidTracker
        );

        $this->assertTrue($return instanceof Canddi_Message_Tracker);
    }
    public function testTriggerAction_CrmGet()
    {
        $strAccountURL      = "anAccount";
        $guidTrigger        = md5(3);
        $guidContact        = md5(1);
        $guidConnection     = md5(2);

        $message        = Canddi_Message::getInstance()->TriggerAction_CrmGet(
            $strAccountURL,
            $guidTrigger,
            $guidContact,
            $guidConnection,
            "Email"
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\CrmGet);
    }
    public function testTriggerAction_CrmSet()
    {
        $strAccountURL      = "anAccount";
        $guidContact        = md5(1);
        $guidConnection     = md5(2);
        $guidTrigger        = md5(3);
        $strMessage         = "Message";

        $message        = Canddi_Message::getInstance()->TriggerAction_CrmSet(
            $strAccountURL,
            $guidTrigger,
            $guidContact,
            $guidConnection,
            $strMessage,
            "Email"
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\CrmSet);
    }
    public function testTriggerAction_ForwardNew()
    {
        $strAccountURL      = "anAccount";
        $strNewEmailAddress = "test@canddi.com";
        $strEmailAddress    = "tim@tim";
        $guidContact        = md5(1);
        $strName            = "Tim Langley";
        $strComment         = "I am a comment";


        $mockGwAccountUser  = Mockery::mock('Canddi_Gateway_AccountUser')
            ->shouldReceive('getByEmailAddress')
            ->once()
            ->with(strtolower($strNewEmailAddress))
            ->andThrow("Canddi_Exception_Fatal_DaoItemNotFound")
            ->mock();

        $mockGateway = Mockery::mock('Canddi_Gateway')
            ->shouldReceive('getAccountUser')
            ->once()
            ->andReturn($mockGwAccountUser)
            ->mock();
        Canddi_Gateway::inject($mockGateway);

        $message        = Canddi_Message::getInstance()->TriggerAction_Forward(
            $strNewEmailAddress,
            $strName,
            $strEmailAddress,
            $strAccountURL,
            $guidContact,
            $strComment
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\ForwardNew);
    }
    public function testTriggerAction_Hipchat()
    {
        $strAccountURL      = "anAccount";
        $arrGCMTokens       = [md5(2)];
        $strEmailAddress    = "tim@canddi.com";
        $guidContact        = md5(1);

        $mockSettings       = Mockery::mock("Canddi_TriggerAction_Model_Hash_NotifyHipchat")
            ->shouldReceive('getHeader')
            ->once()
            ->shouldReceive('getAPIKey')
            ->once()
            ->shouldReceive('getRoom')
            ->once()
            ->mock();

        $mockTrigger        = Mockery::mock(NS_TriggerActionModel_NotifyHipchat::class)
            ->shouldReceive('getAccountURL')
            ->once()
            ->andReturn($strAccountURL)
            ->shouldReceive('getTriggerType')
            ->once()
            ->andReturn('New')
            ->shouldReceive('getSettings')
            ->once()
            ->andReturn($mockSettings)
            ->shouldReceive('getId')
            ->once()
            ->mock();

        $message            = Canddi_Message::getInstance()->TriggerAction_Hipchat(
            $guidContact,
            $mockTrigger
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\NotifyHipchat);
    }
    public function testTriggerAction_NotifyNew()
    {
        $strAccountURL      = "anAccount";
        $strEmailAddress    = "tim@canddi.com";
        $guidContact        = md5(1);
        $strName            = "Tim Langley";

        $mockSettings       = Mockery::mock("Canddi_TriggerAction_Model_Hash_Notify")
            ->shouldReceive('getHeader')
            ->once()
            ->shouldReceive('getTitle')
            ->once()
            ->mock();

        $mockTrigger        = Mockery::mock(NS_TriggerActionModel_Notify::class)
            ->shouldReceive('getAccountURL')
            ->once()
            ->andReturn($strAccountURL)
            ->shouldReceive('getTriggerType')
            ->once()
            ->andReturn('New')
            ->shouldReceive('getSettings')
            ->once()
            ->andReturn($mockSettings)
            ->shouldReceive('getId')
            ->once()
            ->shouldReceive('getStreamId')
            ->once()
            ->withNoArgs()
            ->mock();

        $message            = Canddi_Message::getInstance()->TriggerAction_Notify(
            $strEmailAddress,
            $strName,
            $guidContact,
            $mockTrigger
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\NotifyNew);
    }
    public function testTriggerAction_SummaryNightlyNew()
    {
        $strAccountURL          = 'anAccount';
        $strAccountName         = 'Canddi Motors';
        $strEmailAddress        = "tim@canddi.com";
        $arrStreamData          = [];
        $intTime                = time();
        $arrAlerts              = [];

        $message        = Canddi_Message::getInstance()->TriggerAction_SummaryNightly(
            $strAccountURL,
            $strAccountName,
            $strEmailAddress,
            $arrStreamData,
            $intTime
        );
        $this->assertTrue($message instanceof NS_MessageTriggerAction\SummaryNightlyNew);
    }
    public function testTrigger_New()
    {
        $strAccountURL  = "anAccount";
        $guidContact    = md5(2);
        $arrStreamIds   = [md5(1)];

        $return         = Canddi_Message::getInstance()->Trigger_New(
            $strAccountURL,
            $guidContact,
            $arrStreamIds
        );

        $this->assertTrue($return instanceof Canddi_Message_Trigger_New);
    }
    public function testTrigger_CdnRatelimit()
    {
        $strAccountURL  = "anAccount";
        $guidContact    = md5(2);

        $return         = Canddi_Message::getInstance()->Trigger_CdnRatelimit(
            $strAccountURL,
            $guidContact
        );

        $this->assertTrue($return instanceof Canddi_Message_Trigger_Ratelimit);
    }
    public function testTrigger_Remove()
    {
        $strAccountURL  = "anAccount";
        $guidContact    = md5(2);
        $arrStreamIds   = [md5(1)];

        $return         = Canddi_Message::getInstance()->Trigger_Remove(
            $strAccountURL,
            $guidContact,
            $arrStreamIds
        );

        $this->assertTrue($return instanceof Canddi_Message_Trigger_Remove);
    }
    public function testTrigger_Returning()
    {
        $strAccountURL  = "anAccount";
        $guidContact    = md5(2);
        $arrStreamIds   = [md5(1)];

        $return         = Canddi_Message::getInstance()->Trigger_Returning(
            $strAccountURL,
            $guidContact,
            $arrStreamIds
        );

        $this->assertTrue($return instanceof Canddi_Message_Trigger_Returning);
    }
    public function testTrigger_Schedule_Summary()
    {
        $strAccountURL  = "anAccount";

        $return         = Canddi_Message::getInstance()->Trigger_Schedule_Summary(
            $strAccountURL
        );

        $this->assertTrue($return instanceof Canddi_Message_Trigger_Schedule_Summary);
    }
    public function testTrigger_BrowserPush()
    {
        $strTitle       = "A title";
        $strIcon        = "An icon";
        $strBody        = "A body";
        $strTargetURL   = "A target url";
        $strAccountURL  = "canddi-motors";
        $strEmailAddress= "test@canddi.com";
        $arrSettings    = [];

        $return         = Canddi_Message::getInstance()->TriggerAction_BrowserPush(
            $strTitle,
            $strIcon,
            $strBody,
            $strTargetURL,
            $arrSettings,
            $strAccountURL,
            $strEmailAddress
        );

        $this->assertTrue($return instanceof NS_MessageTriggerAction\BrowserPush);
    }
    public function testTrigger_GDPRSettings()
    {
        $strAccountURL  = "canddi-motors";
        $strEmailAddress= "test@canddi.com";
        $bAnonymise         = true;
        $intMonthsIp        = 3;
        $intMonthsCookie    = 6;
        $intMonthsAll       = 12;

        $return         = Canddi_Message::getInstance()->TriggerAction_GDPRSettings(
            $strAccountURL,
            $strEmailAddress,
            $bAnonymise,
            $intMonthsIp,
            $intMonthsCookie,
            $intMonthsAll
        );

        $this->assertTrue($return instanceof NS_MessageTriggerAction\GDPRSettings);
    }
}

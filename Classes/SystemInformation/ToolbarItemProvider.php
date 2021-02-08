<?php

namespace WorldDirect\Buildinfo\SystemInformation;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Localization\LanguageService;
use WorldDirect\Buildinfo\Service\ToolbarService;
use TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent;

/**
 * ToolbarItemProvider
 * 
 * Provides 2 methods to get the "buildNumber" and the "buildTimestamp"
 * 
 * @author Klaus Hörmann-Engl <kho@world-direct.at>
 */
final class ToolbarItemProvider
{
    /**
     * Toolbar service
     * 
     * @var ToolbarService
     */
    protected $toolbarService = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->toolbarService = $objectManager->get(ToolbarService::class,);
    }

    /**
     * Function returns the content for the SystemInformationToolbar
     * 
     * @param SystemInformationToolbarCollectorEvent $event
     * 
     * @return void
     */
    public function getBuildNumber(SystemInformationToolbarCollectorEvent $event): void
    {
        $this->toolbarService->addFileContentToSystemInformation($event, 'buildNumber', 'actions-debug');
    }

    /**
     * Function returns the date of the last build, and the age in days.
     * Uses the file "buildTimestamp.txt" which is generated by the Build process in
     * the Azure Devops Server.
     * 
     * @return void
     */
    public function getBuildDate(SystemInformationToolbarCollectorEvent $event): void
    {
        $this->toolbarService->addFileContentToSystemInformation($event, 'buildTimestamp', 'actions-clock');
    }

    /**
     * Function returns the current composer project git version from the repository.
     * Uses the file "gitVersion.txt" which is genereted by the build projcess in the
     * Azure devops server, or any other build service.
     * 
     * @return void
     */
    public function getGitVersion(SystemInformationToolbarCollectorEvent $event): void
    {
        $this->toolbarService->addFileContentToSystemInformation($event, 'gitVersion', 'actions-git');
    }
}

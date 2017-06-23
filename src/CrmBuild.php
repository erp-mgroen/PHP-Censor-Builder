<?php

namespace PHPCensor\Model\Build;

use PHPCensor\Model\Build;
use PHPCensor\Builder;

class CrmBuild extends RemoteGitBuild
{
    /**
     * Get link to commit from another source (i.e. Github)
     */
    public function getCommitLink()
    {
        $domain = $this->getProject()->getAccessInformation("domain");
        return 'http://' . $domain . '/' . $this->getProject()->getReference() . '/commit/' . $this->getCommitId();
    }

    /**
     * Get link to branch from another source (i.e. Github)
     */
    public function getBranchLink()
    {
        $domain = $this->getProject()->getAccessInformation("domain");
        return 'http://' . $domain . '/' . $this->getProject()->getReference() . '/tree/' . $this->getBranch();
    }

    /**
     * Get link to specific file (and line) in a the repo's branch
     */
    public function getFileLinkTemplate()
    {
        return sprintf(
            'http://%s/%s/blob/%s/{FILE}#L{LINE}',
            $this->getProject()->getAccessInformation("domain"),
            $this->getProject()->getReference(),
            $this->getCommitId()
        );
    }

    /**
     * Get the URL to be used to clone this remote repository.
     */
    protected function getCloneUrl()
    {
        $key = trim($this->getProject()->getSshPrivateKey());

        if (!empty($key)) {
            $user = $this->getProject()->getAccessInformation("user");
            $domain = $this->getProject()->getAccessInformation("domain");
            $port = $this->getProject()->getAccessInformation('port');

            $url = $user . '@' . $domain . ':';

            if (!empty($port)) {
                $url .= $port . '/';
            }

            $url .= $this->getProject()->getReference() . '.git';

            return $url;
        }
    }

    protected function cloneBySsh(Builder $builder, $cloneTo)
    {
        $this->postCloneSetup($builder, $cloneTo);
//        $keyFile       = $this->writeSshKey($cloneTo);
//        $gitSshWrapper = $this->writeSshWrapper($cloneTo, $keyFile);
//        // Do the git clone:
//        $cmd = 'git clone --recursive ';
//        $depth = $builder->getConfig('clone_depth');
//        if (!is_null($depth)) {
//            $cmd .= ' --depth ' . intval($depth) . ' ';
//        }
//        $cmd .= ' -b %s %s "%s"';
//        $cmd = 'export GIT_SSH="'.$gitSshWrapper.'" && ' . $cmd;
//        $success = $builder->executeCommand($cmd, $this->getBranch(), $this->getCloneUrl(), $cloneTo);
//        if ($success) {
//            $success = $this->postCloneSetup($builder, $cloneTo);
//        }
//        // Remove the key file and git wrapper:
//        unlink($keyFile);
//        unlink($gitSshWrapper);
//        return $success;
    }
}

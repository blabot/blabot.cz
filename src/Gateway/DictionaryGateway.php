<?php
declare(strict_types=1);

namespace App\Gateway;


use Blabot\Dictionary\Dictionary;
use Blabot\Gateway\DictionaryGatewayInterface;
use Blabot\Library\JsonLibrary;
use Blabot\StorageAdapter\LocalFSAdapter;

class DictionaryGateway implements DictionaryGatewayInterface
{
    /**
     * @var LocalFSAdapter $adapter
     */
    private $adapter;

    /**
     * @var JsonLibrary
     */
    private $library;

    public function __construct()
    {
        $indexFile = __DIR__ . "/../../vendor/blabot/blabot-dictionaries/index.json";
        $dataDir = __DIR__ . "/../../vendor/blabot/blabot-dictionaries/data";
        $this->adapter = new LocalFSAdapter($indexFile, $dataDir);
        $this->library = new JsonLibrary($this->adapter);
    }


    public function findDictionaryByName($name)
    {
        return $this->library->getDictionary($name);
    }

    public function save(Dictionary $dictionary)
    {
        // TODO: Implement save() method.
    }


}
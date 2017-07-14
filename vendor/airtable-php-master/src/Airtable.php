<php

key   = "APP_KEY"; // Generated from : https://airtable.com/account
$base  = "BASE_ID"; // Find it on : https://airtable.com/api
$table = "TABLE_NAME"; // Find it on : https://airtable.com/api

$airtable    = new Airtable($key, $base);
$indexMember = new MemberIndex($airtable, $table);
use Armetiz\AirtableSDK\Airtable;

class MemberIndex
{
/**
* @var Airtable
*/
private $airtable;

private $table;

/**
* MemberIndexer constructor.
*
* @param Airtable $airtable
* @param          $table
*/
public function __construct(Airtable $airtable, $table)
{
$this->airtable = $airtable;
$this->table    = $table;
}

public function clear()
{
$this->airtable->flushRecords($this->table);
}

public function save(array $data)
{
$this->guardData($data);

$criteria = ["Id" => $data["id"]];
$fields   = [
"Id"                    => $data["id"],
"Firstname"             => $data["firstName"],
"Lastname"              => $data["lastName"],
"Email"                 => $data["email"],
"CreatedAt"             => (string)$data["createdAt"],
];

if ($data["picture"]) {
$record["Picture"] = [
["url" => $data["picture"]],
];
}

if ($this->airtable->containsRecord($this->table, $criteria)) {
$this->airtable->updateRecord($this->table, $criteria, $fields);
} else {
$this->airtable->createRecord($this->table, $fields);
}
}

public function delete($id)
{
$this->airtable->deleteRecord($this->table, ["Id" => $id]);
}

private function guardData(array $data)
{
$requiredKeys = [
"id",
"firstName",
"lastName",
"email",
"picture",
"createdAt",
];

$availableKeys = array_keys($data);
foreach ($requiredKeys as $requiredKey) {
if (!in_array($requiredKey, $availableKeys)) {
throw new \InvalidArgumentException(sprintf(
"Required keys '%s' from data is missing",
$requiredKey
));
}
}
}
}
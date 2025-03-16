<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250316090540 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE data (data VARCHAR NOT NULL)');
        $this->addSql("INSERT INTO data (data) values ('Hello from k8s!')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE data');
    }
}

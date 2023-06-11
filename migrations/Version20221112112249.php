<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221112112249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'added instruction column to cocktail table (PROJ-14)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cocktail ADD instruction LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cocktail DROP instruction');
    }
}

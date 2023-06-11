<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230113150438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'removed stars from cocktail entity (NO-TICKET)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cocktail DROP stars');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cocktail ADD stars INT NOT NULL');
    }
}

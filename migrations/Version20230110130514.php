<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230110130514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'added rating table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cocktail_id INT NOT NULL, stars INT NOT NULL, INDEX IDX_D8892622A76ED395 (user_id), INDEX IDX_D8892622CD6F76C6 (cocktail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622CD6F76C6 FOREIGN KEY (cocktail_id) REFERENCES cocktail (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A76ED395');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622CD6F76C6');
        $this->addSql('DROP TABLE rating');
    }
}

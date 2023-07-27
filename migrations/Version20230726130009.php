<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726130009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produits_enseignes (produits_id INT NOT NULL, enseignes_id INT NOT NULL, INDEX IDX_791B305BCD11A2CF (produits_id), INDEX IDX_791B305BC01FD685 (enseignes_id), PRIMARY KEY(produits_id, enseignes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produits_enseignes ADD CONSTRAINT FK_791B305BCD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produits_enseignes ADD CONSTRAINT FK_791B305BC01FD685 FOREIGN KEY (enseignes_id) REFERENCES enseignes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits_enseignes DROP FOREIGN KEY FK_791B305BCD11A2CF');
        $this->addSql('ALTER TABLE produits_enseignes DROP FOREIGN KEY FK_791B305BC01FD685');
        $this->addSql('DROP TABLE produits_enseignes');
    }
}

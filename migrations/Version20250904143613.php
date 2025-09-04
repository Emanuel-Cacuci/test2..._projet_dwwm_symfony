<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250904143613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_adresse (utilisateur_id INT NOT NULL, adresse_id INT NOT NULL, INDEX IDX_B954FF84FB88E14F (utilisateur_id), INDEX IDX_B954FF844DE7DC5C (adresse_id), PRIMARY KEY(utilisateur_id, adresse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_adresse ADD CONSTRAINT FK_B954FF84FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_adresse ADD CONSTRAINT FK_B954FF844DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD adresse_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4DE7DC5C ON commande (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_adresse DROP FOREIGN KEY FK_B954FF84FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_adresse DROP FOREIGN KEY FK_B954FF844DE7DC5C');
        $this->addSql('DROP TABLE utilisateur_adresse');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4DE7DC5C');
        $this->addSql('DROP INDEX IDX_6EEAA67D4DE7DC5C ON commande');
        $this->addSql('ALTER TABLE commande DROP adresse_id');
    }
}

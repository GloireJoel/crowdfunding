<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525144756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9A737ED74');
        $this->addSql('DROP INDEX IDX_50159CA9A737ED74 ON projet');
        $this->addSql('ALTER TABLE projet CHANGE financement_id financements_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9B0BE3FED FOREIGN KEY (financements_id) REFERENCES financement (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9B0BE3FED ON projet (financements_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9B0BE3FED');
        $this->addSql('DROP INDEX IDX_50159CA9B0BE3FED ON projet');
        $this->addSql('ALTER TABLE projet CHANGE financements_id financement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9A737ED74 FOREIGN KEY (financement_id) REFERENCES financement (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9A737ED74 ON projet (financement_id)');
    }
}

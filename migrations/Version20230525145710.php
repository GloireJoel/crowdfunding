<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525145710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE financement ADD projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE financement ADD CONSTRAINT FK_59895F56C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_59895F56C18272 ON financement (projet_id)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9B0BE3FED');
        $this->addSql('DROP INDEX IDX_50159CA9B0BE3FED ON projet');
        $this->addSql('ALTER TABLE projet DROP financements_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE financement DROP FOREIGN KEY FK_59895F56C18272');
        $this->addSql('DROP INDEX IDX_59895F56C18272 ON financement');
        $this->addSql('ALTER TABLE financement DROP projet_id');
        $this->addSql('ALTER TABLE projet ADD financements_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9B0BE3FED FOREIGN KEY (financements_id) REFERENCES financement (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9B0BE3FED ON projet (financements_id)');
    }
}

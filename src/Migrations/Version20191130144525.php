<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191130144525 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job_offer_tag (job_offer_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E80C390A3481D195 (job_offer_id), INDEX IDX_E80C390ABAD26311 (tag_id), PRIMARY KEY(job_offer_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_offer_tag ADD CONSTRAINT FK_E80C390A3481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer_tag ADD CONSTRAINT FK_E80C390ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE job_offer_tag');
    }
}
